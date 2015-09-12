<?php
/**
 * Created by PhpStorm.
 * Person: FlorianAlexander
 * Date: 5/18/2015
 * Time: 7:45 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/services/databasehelper.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/models/persondisplaymodel.php";

function GetAllPersonsForList()
{
    $db = GetDatabaseConnection();
    $stmt = $db->prepare('SELECT Id, Vorname, Nachname, Adresswarnung
				FROM persons
				ORDER BY Nachname, Vorname');
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_CLASS, "PersonDisplayModel");
    return $result;
}

function GetAllPersonIds()
{
    $db = GetDatabaseConnection();
    $stmt = $db->prepare('SELECT Id FROM persons ORDER BY Id');
    $stmt->execute();

    $result = $stmt->fetchAll();
    $ids = array();
    foreach ($result as $key => $val) {
        $ids[$val["Id"]] = $val["Id"];
    }
    return $ids;
}