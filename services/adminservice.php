<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 23.05.2015
 * Time: 14:01
 */

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
    $res = AddOrUpdate("admins", $params);
    if ($res !== false) {
        if (SendMail($params["Email"], null, APPLICATION_TITLE, "Sie wurden gerade als admin auf ".BASEURL." (".APPLICATION_TITLE.") hinzugefügt. Folgen Sie diesem Link, um die Registrierung abzuschliessen: " . BASEURL . "activateAccount/" . $params["AuthHash"]))
            return $res;
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
        $res = AddOrUpdate("admins", $params);
        if ($res !== false)
            return SendMail($email, $admin->GetIdentification(), "Passwort zurückgesetzt", "Ihr Passwort auf ".BASEURL." (".APPLICATION_TITLE.") wurde zurückgesetzt. Folgen Sie diesem Link, um die Registrierung abzuschliessen: " . BASEURL . "activateAccount/" . $params["AuthHash"] . "
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