<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 23.05.2015
 * Time: 13:52
 */

class PersonsController extends ControllerBase
{
    private $request = null;
    private $params = null;

    private $genericController = null;

    /**
     * Konstruktor, erstellet den Controller.
     *
     * @param Array $request Array aus $_GET & $_POST.
     */
    public function __construct($request, $requestFiles, $params)
    {
        $this->request = $request;
        $this->params = $params;
        $this->genericController = new GenericController($this->request,$this->params,"persons", "Person", "LastName, FirstName", array("add" => "edit"));
    }

    function getMenu()
    {
        $res = array();
        $menuItem = array();
        $menuItem["href"] = "";
        $menuItem["content"] = "Alle";
        $res[] = $menuItem;
        $menuItem2 = array();
        $menuItem2["href"] = "walter";
        $menuItem2["content"] = "Vorname Walter";
        $res[] = $menuItem2;
        return $res;
    }

    /**
     * Methode zum Anzeigen des Contents.
     *
     * @return String Content der Applikation.
     */
    public function Display()
    {
        $view = $this->NotFound();
        if (count($this->params) == 0 || $this->params[0] == "") {
            return $this->genericController->Display();
        } else {
            if ($this->params[0] == "add") {
                return $this->genericController->Display();
            } else if ($this->params[0] == "edit" && isset($this->params[1]) && is_numeric($this->params[1])) {
                return $this->genericController->Display();
            } else if ($this->params[0] == "delete" && isset($this->params[1]) && is_numeric($this->params[1])) {
                return $this->genericController->Display();
            }
        }

        return $view->loadTemplate();
    }
}