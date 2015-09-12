<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 09.09.2015
 * Time: 23:43
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/controller/controllerbase.php";

class ApiController extends ControllerBase
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
     * Methode zum anzeigen des Contents.
     *
     * @return String Content der Applikation.
     */
    public function Display()
    {
        //not authentication required to access this controller, be carefull
        $view = $this->NotFound();
        if ($this->params[0] == "log") {
            if (isset($this->request["message"]) && isset($this->request["loglevel"]))
                DoLog($this->request["message"], $this->request["loglevel"]);
            $view = new RawView("/templates/parts/messagetemplate.php");
        }
        return $view->loadTemplate();
    }
}