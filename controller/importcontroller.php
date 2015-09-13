<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 11:55
 *
 */

class ImportController extends ControllerBase
{
    private $request = null;
    private $params = null;
    private $requestFiles = null;

    /**
     * Konstruktor, erstellet den Controller.
     *
     * @param Array $request Array aus $_GET & $_POST.
     */
    public function __construct($request, $requestFiles, $params)
    {
        $this->request = $request;
        $this->params = $params;
        $this->requestFiles = $requestFiles;
    }

    /**
     * Methode zum Anzeigen des Contents.
     *
     * @return String Content der Applikation.
     */
    public function Display()
    {
        $view = new GenericView("import");
        if (count($this->params) == 0 || $this->params[0] == "") {
            //no params: default
        } else if ($this->params[0] == "upload") {
            if ($this->request["step"] == "1") {
                $filetype = FileTypeUploadedFile('importfile');
                if ($filetype == "sql") {
                    $filepath = $_SERVER['DOCUMENT_ROOT'] . "/import/" . uniqid() . ".sql";
                    $resp = ValidateUploadedFile('importfile', $filepath);
                    if ($resp !== true) {
                        DoLog("Upload failed", LOG_LEVEL_USER_ERROR);
                    } else {
                        if (ImportDatabase(false, $filepath)) {
                            $view->assign("filepath", $filepath);
                            $view->assign("type", "database");
                            $view->assign("step", 2);
                        }
                    }
                } else if ($filetype == "xls" || $filetype == "xlsx") {
                    $filepath = $_SERVER['DOCUMENT_ROOT'] . "/import/" . uniqid() . ".xlsx";
                    $resp = ValidateUploadedFile('importfile', $filepath);
                    if ($resp !== true) {
                        DoLog("Upload failed", LOG_LEVEL_USER_ERROR);
                    } else {
                        if (ImportPersons(false, $filepath)) {
                            $view->assign("filepath", $filepath);
                            $view->assign("type", "persons");
                            $view->assign("step", 2);
                        }
                    }
                } else {
                    DoLog("Unbekanntes Dateiformat: ".$filetype, LOG_LEVEL_USER_ERROR);
                }
            } else if ($this->request["step"] == "2") {
                if ($this->request["type"] == "database"){
                    ImportDatabase(true, $this->request["filepath"]);
                } else if ($this->request["type"] == "persons") {
                    ImportPersons(true, $this->request["filepath"]);
                } else {
                    DoLog("Import konnte nicht ausgeführt werden", LOG_LEVEL_SYSTEM_ERROR);
                }
            } else {
                DoLog("Import konnte nicht ausgeführt werden", LOG_LEVEL_SYSTEM_ERROR);
            }
        }
        return $view->loadTemplate();
    }
}