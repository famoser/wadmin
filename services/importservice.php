<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 04.06.2015
 * Time: 21:28
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/libraries/PHPExcel/IOFactory.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/services/userservice.php";

function ImportPersons($execute, $filename)
{
    $persons = GetPersonsFromExcel($filename);

    $ids = GetPropertyByCondition("persons", null, "Id");
    if ($execute) {
        foreach ($persons as $person) {
            $res = AddOrUpdate("persons", $person);
            if (is_bool($res))
                $id = $person->Id;
            else
                $id = $res;

            if(($key = array_search($id, $ids)) !== false) {
                unset($ids[$key]);
            }
        }
        $deleted = 0;
        foreach ($ids as $id) {
            DeleteById("persons", $id);
            $deleted++;
        }
        DoLog("Der Import wurde erfolgreich abgeschlossen");
        DoLog("Gelöscht:" .$deleted);
    } else {
        $faillures = 0;
        $newIds = array();
        $updateIds = array();
        foreach ($persons as $person) {
            if (in_array($person->Id, $ids)) {
                if (!in_array($person->Id, $updateIds)) {
                    $updateIds[] = $person->Id;

                    if(($key = array_search($person->Id, $ids)) !== false) {
                        unset($ids[$key]);
                    }
                } else {
                    $faillures++;
                    DoLog("Id doppelt vergeben: " . $person->GetIdentification() . " hat die Id " . $person->Id . ", die jedoch schon vergeben ist", LOG_LEVEL_USER_ERROR);
                }
            } else {
                if (in_array($person->Id, $newIds) || in_array($person->Id, $updateIds)) {
                    $faillures++;
                    DoLog("Id doppelt vergeben: " . $person->GetIdentification() . " hat die Id " . $person->Id . ", die jedoch schon vergeben ist", LOG_LEVEL_USER_ERROR);
                } else
                    $newIds[] = $person->Id;
            }
        }
        if ($faillures > 0) {
            DoLog("Es traten '.$faillures.' Fehler auf. Es werden " . count($ids) . " Zeilen gelöscht, " . count($updateIds) . " Zeilen aktualisiert und " . count($newIds) . " Zeilen hinzugefügt", LOG_LEVEL_USER_ERROR);
            return false;
        } else {
            DoLog("Alles sieht gut aus. Es werden " . count($ids) . " Zeilen gelöscht, " . count($updateIds) . " Zeilen aktualisiert und " . count($newIds) . " Zeilen hinzugefügt", LOG_LEVEL_USER_ERROR);
            DoLog("delete: " .json_encode($ids));
            DoLog("add: " .json_encode($newIds));
            DoLog("update: " .json_encode($updateIds));


            return true;
        }
    }
}

function ImportDatabase($execute, $filename)
{
    if (!$execute) {
        DoLog("Diese Datei enthält eine Sicherung der Datenbank. Die Datenbank wir dadurch auf den Zeitpunkt des Exportes zurückgesetzt. Dieser Vorgang kann nicht rückgängig gemacht werden!", LOG_LEVEL_USER_ERROR);
        return true;
    }
    $command = 'mysql -h ' . DATABASE_HOST . ' -u ' . DATABASE_USER . ' -p' . DATABASE_USER_PASSWORD . ' ' . DATABASE_NAME . ' < ' . $filename;

    exec($command, $output = array(), $worked);

    switch ($worked) {

        case 0:
            DoLog('Der Import wurde erfolgreich abgeschlossen');
            break;
        case 1:
            DoLog('Der Import ist fehlgeschlagen! (0)');
            break;
        default:
            DoLog('Der Import ist fehlgeschlagen! (1)');
            break;
    }
    return true;
}

function GetPersonsFromExcel($excelPath)
{
    $instance = PHPExcel_IOFactory::load($excelPath);

    /* Sheet 0 */
    $i = 2;
    $retries = 0;

    $users = array();
    while (true) {
        if ($instance->setActiveSheetIndex(0)->getCell("A" . $i)->getValue() == "") {
            if ($retries++ > 3)
                break;
            else
                continue;
        }

        $retries = 0;

        $user = new PersonModel();
        $user->Id = $instance->setActiveSheetIndex(0)->getCell("A" . $i)->getValue();
        $user->FirstName = $instance->setActiveSheetIndex(0)->getCell("B" . $i)->getValue();
        $user->LastName = $instance->setActiveSheetIndex(0)->getCell("C" . $i)->getValue();
        $user->AdressExtension = $instance->setActiveSheetIndex(0)->getCell("D" . $i)->getValue();
        $user->Street = $instance->setActiveSheetIndex(0)->getCell("E" . $i)->getValue();
        $user->Land = $instance->setActiveSheetIndex(0)->getCell("F" . $i)->getValue();
        $user->ZipCode = $instance->setActiveSheetIndex(0)->getCell("G" . $i)->getValue();
        $user->Place = $instance->setActiveSheetIndex(0)->getCell("H" . $i)->getValue();
        $user->TelPrivat = $instance->setActiveSheetIndex(0)->getCell("I" . $i)->getValue();
        $user->TelBusiness = $instance->setActiveSheetIndex(0)->getCell("J" . $i)->getValue();
        $user->Mobile = $instance->setActiveSheetIndex(0)->getCell("K" . $i)->getValue();
        $user->Email = $instance->setActiveSheetIndex(0)->getCell("L" . $i)->getValue();
        $user->BirthDate = ConvertFromExcelDate($instance->setActiveSheetIndex(0)->getCell("M" . $i)->getValue());
        $user->Description = $instance->setActiveSheetIndex(0)->getCell("N" . $i)->getValue();
        $user->AdressAlertBool = ConvertFromExcelBool($instance->setActiveSheetIndex(0)->getCell("O" . $i)->getValue());
        $user->WakeUpTime = ConvertFromExcelTime($instance->setActiveSheetIndex(0)->getCell("O" . $i)->getValue());

        $users[] = $user;
        $i++;
    }

    return $users;
}

function ConvertFromExcelBool($val)
{
    if ($val == "Ja" || $val == 1)
        return true;
    else
        return false;
}

function ConvertFromExcelDate($input)
{
    if ($input != null) {
        $date = DateTime::createFromFormat(DATE_FORMAT_DISPLAY, $input);
        if ($date!= false)
            return $date->format(DATE_FORMAT_DATABASE);
    }
    return null;
}

function ConvertFromExcelDateTime($input)
{
    if ($input != null) {
        $date = DateTime::createFromFormat(DATETIME_FORMAT_DISPLAY, $input);
        if ($date!= false)
            return $date->format(DATETIME_FORMAT_DATABASE);
    }
    return null;
}

function ConvertFromExcelTime($input)
{
    if ($input != null) {
        $date = DateTime::createFromFormat(TIME_FORMAT_DISPLAY, $input);
        if ($date!= false)
            return $date->format(TIME_FORMAT_DATABASE);
    }
    return null;
}