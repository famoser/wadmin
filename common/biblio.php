<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 24.05.2015
 * Time: 10:10
 */

function IncludeIfNecessary($path)
{
    include_once $_SERVER['DOCUMENT_ROOT'].$path;
}

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

function sanitize_output($buffer) {

    // Searching textarea and pre
    preg_match_all('#\<textarea.*\>.*\<\/textarea\>#Uis', $buffer, $foundTxt);
    preg_match_all('#\<pre.*\>.*\<\/pre\>#Uis', $buffer, $foundPre);

    // replacing both with <textarea>$index</textarea> / <pre>$index</pre>
    $buffer = str_replace($foundTxt[0], array_map(function($el){ return '<textarea>'.$el.'</textarea>'; }, array_keys($foundTxt[0])), $buffer);
    $buffer = str_replace($foundPre[0], array_map(function($el){ return '<pre>'.$el.'</pre>'; }, array_keys($foundPre[0])), $buffer);

    // your stuff
    $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
    );

    $replace = array(
        '>',
        '<',
        '\\1'
    );

    $buffer = preg_replace($search, $replace, $buffer);

    // Replacing back with content
    $buffer = str_replace(array_map(function($el){ return '<textarea>'.$el.'</textarea>'; }, array_keys($foundTxt[0])), $foundTxt[0], $buffer);
    $buffer = str_replace(array_map(function($el){ return '<pre>'.$el.'</pre>'; }, array_keys($foundPre[0])), $foundPre[0], $buffer);

    return $buffer;
}

function GetDatabaseConnection()
{
    IncludeIfNecessary("/common/configuration.php");
    $db = new PDO("mysql:host=" . DATABASE_HOST .";dbname=" . DATABASE_NAME . ";charset=utf8",DATABASE_USER,DATABASE_USER_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $db;
}

function str_startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
function str_endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}