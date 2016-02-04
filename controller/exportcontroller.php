<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 11:55
 *
 */

class ExportController extends ControllerBase
{
    private $request = null;
    private $params = null;

    /**
     * Konstruktor, erstellet den Controller.
     *
     * @param Array $request Array aus $_GET & $_POST.
     */
    public function __construct($request, $requestFiles, $params)
    {
        $this->request = $request;
        $this->params = $params;
    }

    /**
     * Methode zum Anzeigen des Contents.
     *
     * @return String Content der Applikation.
     */
    public function Display()
    {
        $view = new GenericView("export");
        if (count($this->params) == 0 || $this->params[0] == "") {
            //no params: default
        }
        else if ($this->params[0] == "download")
        {
            $params = RemoveFirstEntryInArray($this->params);
            if ($params[0] == "excel")
                DownloadPersonsAndExit();
            else if ($params[0] == "database")
                DownloadDatabaseAndExit();
        }
        return $view->loadTemplate();
    }
}