<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 23.05.2015
 * Time: 09:47
 */

include_once $_SERVER['DOCUMENT_ROOT']."/common/configuration.php";

function GetDatabaseConnection()
{
    $db = new PDO("mysql:host=" . DATABASE_HOST .";dbname=" . DATABASE_NAME . ";charset=utf8",DATABASE_USER,DATABASE_USER_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $db;
}