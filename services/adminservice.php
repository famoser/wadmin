<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 23.05.2015
 * Time: 14:01
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/services/userservice.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/services/adminservice.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/services/emailservice.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/models/adminmodel.php";

function TryLogin($Email, $Pass)
{
    $admin = GetSingleByCondition("admins", array("Email" => $Email));
    if ($admin !== false && password_verify($Pass, $admin->PasswordHash)) {
        if ($admin->PersonId != 0)
            $admin->Person = GetById("persons", $admin->PersonId);
        return $admin;
    }
    return false;
}

function AddAdmin($params)
{
    $db = GetDatabaseConnection();
    $stmt = $db->prepare('SELECT * FROM admins WHERE Email = :Email');
    $stmt->bindParam(":Email", $params["Email"]);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_CLASS, "AdminModel");
    if (isset($result[0])) {
        DoLog("Es existiert bereits ein Admin mit dieser E-Mail", LOG_LEVEL_USER_ERROR);
        return false;
    }

    $params["AuthHash"] = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
    if (AddOrUpdate("admins", $params) > 0) {
        return SendMail($params["Email"], "Admin der Froburger Addressverwaltung", "Sie wurden gerade als admin in der Addressverwaltung der Froburger hinzugefügt. Folgen Sie diesem Link, um die Registrierung abzuschliessen: " . BASEURL . "activateAccount/" . $params["AuthHash"]);
    }
    DoLog("Admin konnte nicht aktualisiert werden", LOG_LEVEL_SYSTEM_ERROR);
    return false;
}

function ResetAdminPassByEmail($email)
{
    $admin = GetSingleByCondition("admins", array("Email" => $email));
    if ($admin !== false) {
        $params = array();
        $params["Id"] = $admin->Id;
        $params["AuthHash"] = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
        if (AddOrUpdate("admins", $params))
            return SendMail($email, "Passwort zurückgesetzt", "Ihr Passwort der Addressverwaltung der Froburger wurde zurückgesetzt. Folgen Sie diesem Link, um die Registrierung abzuschliessen: " . BASEURL . "activateAccount/" . $params["AuthHash"] . "
Wenn Sie diese E-Mail nicht angefordert haben, können Sie sie ignorieren");
    }
    return false;
}

function SetAdminPassWithHash($arr)
{
    $admin = GetSingleByCondition("admins", array("AuthHash" => $arr["AuthHash"], "Id" => $arr["Id"]));
    if ($admin !== false) {
        $params = array();
        $params["Id"] = $arr["Id"];
        $params["AuthHash"] = "";
        $params["PasswordHash"] = $arr["Password"];
        return AddOrUpdate("admins", $arr);
    }
    DoLog("Hash ungültig, Admin wurde nicht gefunden.", LOG_LEVEL_SYSTEM_ERROR);
    return false;
}