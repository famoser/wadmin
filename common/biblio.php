<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 24.05.2015
 * Time: 10:10
 */

function RemoveFirstEntryInArray($arr)
{
    unset($arr[0]);
    return array_values($arr);
}

function GetActiveUser()
{
    if (isset($_SESSION["admin"]))
        return unserialize($_SESSION["admin"]);
    else
        return false;
}

function SetActiveUser($usr)
{
    $_SESSION["admin"] = serialize($usr);
}

function RemoveActiveUser()
{
    if (isset($_SESSION["admin"]))
        unset($_SESSION["admin"]);
}

function IsAjaxRequest()
{
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        return true;
    return false;
}

function FileTypeUploadedFile($tempfilename)
{
    $arr = explode(".", $_FILES[$tempfilename]["name"]);
    return $arr[count($arr) - 1];
}

function ValidateUploadedFile($tempfilename, $newpath = null)
{
    if (!isset($_FILES[$tempfilename]["tmp_name"])) {
        return "Datei wurde nicht gefunden";
    }
    if ($_FILES[$tempfilename]["error"] != UPLOAD_ERR_OK)
        return "Folgender Error ist beim Upload aufgetreten: " . $_FILES[$tempfilename]["error"];

    if ($newpath == null)
        return true;

    if (!move_uploaded_file($_FILES[$tempfilename]["tmp_name"], $newpath))
        return "Datei kann nicht gespeichert werden";

    return true;
}

function CheckPassword($passwd)
{
    if (strlen($passwd) > 20) {
        DoLog("Passwort zu lang (maximal 20 Zeichen)", LOG_LEVEL_USER_ERROR);
        return false;
    }

    if (strlen($passwd) < 8) {
        DoLog("Passwort zu kurz (mindestens 8 Zeichen)", LOG_LEVEL_USER_ERROR);
        return false;
    }

    if (!preg_match("#[0-9]+#", $passwd)) {
        DoLog("Passwort muss mindestens eine Zahl enthalten", LOG_LEVEL_USER_ERROR);
        return false;
    }

    if (!preg_match("#[a-z]+#", $passwd)) {
        DoLog("Passwort muss mindestens ein Buchstabe enthalten", LOG_LEVEL_USER_ERROR);
        return false;
    }

    return true;
}

function GetClassesForMenuItem($view, $params = null)
{
    if ($params == null || count($params) == 0 || $view->params == null || count($view->params) == 0)
        return "";

    $isSamePage = true;
    for ($i = 0; $i < count($params); $i++) {
        if (!isset($view->params[$i]) || $view->params[$i] != $params[$i]) {
            $isSamePage = false;
        }
    }
    if (!$isSamePage)
        return "";
    $classes = "active";
    if (count($params) == count($view->params))
        $classes .= " active-page";

    return ' class="' . $classes . '" ';
}

function DoLog($message, $loglevel = LOG_LEVEL_INFO)
{
    if (!isset($_SESSION["log"]))
        $_SESSION["log"] = array();

    $arr = array();
    $arr["message"] = $message;
    $arr["loglevel"] = $loglevel;
    if ($loglevel == LOG_LEVEL_INFO)
        $arr["class"] = "info";
    else if ($loglevel == LOG_LEVEL_USER_ERROR)
        $arr["class"] = "user-error";
    else if ($loglevel == LOG_LEVEL_SYSTEM_ERROR)
        $arr["class"] = "system-error";
    $_SESSION["log"][] = $arr;
}

function GetLog()
{
    if (isset($_SESSION["log"])) {
        $temp = $_SESSION["log"];
        unset($_SESSION["log"]);
        return $temp;
    }
    return null;
}