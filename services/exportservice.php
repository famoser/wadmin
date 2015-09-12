<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 10:40
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/libraries/PHPExcel/IOFactory.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/services/userservice.php";

function DownloadUsersAndExit()
{
    $instance = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'] . "/export/exporttemplates/persons.xlsx");

    $users = GetAllOrderedBy("persons", "LastName, FirstName", false);
    for ($i = 0; $i < count($users); $i++) {
        $instance->setActiveSheetIndex(0)->setCellValue("A" . ($i + 2), $users[$i]->Id);
        $instance->setActiveSheetIndex(0)->setCellValue("B" . ($i + 2), $users[$i]->FirstName)
            ->setCellValue("C" . ($i + 2), $users[$i]->LastName)
            ->setCellValue("D" . ($i + 2), $users[$i]->AdressExtension)
            ->setCellValue("E" . ($i + 2), $users[$i]->Street)
            ->setCellValue("F" . ($i + 2), $users[$i]->Land)
            ->setCellValue("G" . ($i + 2), $users[$i]->ZipCode)
            ->setCellValue("H" . ($i + 2), $users[$i]->Place)
            ->setCellValue("I" . ($i + 2), $users[$i]->TelPrivat)
            ->setCellValue("J" . ($i + 2), $users[$i]->TelBusiness)
            ->setCellValue("K" . ($i + 2), $users[$i]->Mobile)
            ->setCellValue("L" . ($i + 2), $users[$i]->Email)
            ->setCellValue("M" . ($i + 2), ConvertToExcelDate($users[$i]->BirthDate))
            ->setCellValue("N" . ($i + 2), $users[$i]->Description)
            ->setCellValue("O" . ($i + 2), ConvertToExcelBool($users[$i]->AdressAlertBool))
            ->setCellValue("P" . ($i + 2), ConvertToExcelTime($users[$i]->WakeUpTime))
            ->setCellValue("Q" . ($i + 2), ConvertToExcelDateTime($users[$i]->FirstContactDateTime));
    }

    $objWriter = PHPExcel_IOFactory::createWriter($instance, 'Excel2007');// We'll be outputting an excel file

    header('Content-type: application/vnd.ms-excel');

    // It will be called file.xls
    header('Content-Disposition: attachment; filename="persons.xlsx"');

    // Write file to the browser
    $objWriter->save('php://output');
    exit;
}

function DownloadDatabaseAndExit()
{
    $filename = $_SERVER['DOCUMENT_ROOT'] . "/export/" . date("Y-m-d-H-i") . ".sql";

    $fp = @fopen($filename, 'w+');
    if (!$fp) {
        DoLog("Sicherungsdatei konnte nicht erstellt werden (0)", LOG_LEVEL_SYSTEM_ERROR);
    }

    $command = 'mysqldump --opt -h ' . DATABASE_HOST . ' -u ' . DATABASE_USER . ' -p' . DATABASE_USER_PASSWORD . ' ' . DATABASE_NAME . ' > ' . $filename;

    exec($command, $output = array(), $worked);

    switch ($worked) {

        case 0:
            if (file_exists($filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . APPLICATION_TITLE . '-database-export-' . basename($filename));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                readfile($filename);
                exit;
            } else
                DoLog("Sicherungsdatei wurde nicht gefunden", LOG_LEVEL_SYSTEM_ERROR);
            break;

        case 1:
            DoLog("Sicherungsdatei konnte nicht erstellt werden (1)", LOG_LEVEL_SYSTEM_ERROR);
            break;

        default:
            DoLog("Sicherungsdatei konnte nicht erstellt werden (2)", LOG_LEVEL_SYSTEM_ERROR);
            break;
    }
    return false;
}

function ConvertToExcelBool($val)
{
    if ($val)
        return "Ja";
    else
        return "Nein";
}

function ConvertToExcelDate($input)
{
    if ($input != null) {
        $date = DateTime::createFromFormat(DATE_FORMAT_DATABASE, $input);
        if ($date!= false)
            return $date->format(DATE_FORMAT_DISPLAY);
    }
    return null;
}

function ConvertToExcelDateTime($input)
{
    if ($input != null) {
        $date = DateTime::createFromFormat(DATETIME_FORMAT_DATABASE, $input);
        if ($date!= false)
            return $date->format(DATETIME_FORMAT_DISPLAY);
    }
    return null;
}

function ConvertToExcelTime($input)
{
    if ($input != null) {
        $date = DateTime::createFromFormat(TIME_FORMAT_DATABASE, $input);
        if ($date!= false)
            return $date->format(TIME_FORMAT_DISPLAY);
    }
    return null;
}