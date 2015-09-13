<?php

/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 23.05.2015
 * Time: 13:52
 */
class GenericController extends ControllerBase
{
    private $request = null;
    private $params = null;
    private $table = null;
    private $object = null;
    private $orderby = null;
    private $replaces = null;
    private $controllerreplaces = null;
    private $submenu = null;

    /**
     * Konstruktor, erstellet den Controller.
     *
     * @param Array $request Array aus $_GET & $_POST.
     */
    public function __construct($request, $params, $table, $object, $orderBy, $replaces = null, $controllerreplaces = null, $submenu = null)
    {
        $this->request = $request;
        $this->params = $params;
        /*
        $this->table = "persons";
        $this->object = "Person";
        $this->orderby = "Nachname, Vorname";
        $this->replaces = array("add" => "edit");
        */
        $this->table = $table;
        $this->object = $object;
        $this->orderby = $orderBy;
        $this->replaces = $replaces;
        $this->controllerreplaces = $controllerreplaces;
        $this->submenu = $submenu;
    }

    function IsReplaced($targetValue)
    {
        return $this->controllerreplaces != null &&
        is_array($this->controllerreplaces) &&
        isset($this->controllerreplaces[$this->params[0]]) &&
        isset($this->controllerreplaces[$this->params[0]]) == $targetValue;
    }

    /**
     * Methode zum Anzeigen des Contents.
     *
     * @return String Content der Applikation.
     */
    public function Display()
    {
        if (count($this->params) == 0 || $this->params[0] == "" || $this->IsReplaced("")) {
            $view = new GenericView($this->table, $this->submenu);
            $view->assign($this->table, GetAllOrderedBy($this->table, $this->orderby));
        } else {
            $view = new GenericCrudView($this->params[0], $this->replaces, $this->table);
            if ($this->params[0] == "add" || $this->IsReplaced("add")) {
                if (isset($this->request["add"]) && $this->request["add"] == "true") {
                    unset($this->request["add"]);

                    $res = AddOrUpdate($this->table, $this->request);
                    $obj = GetById($this->table, $res);
                    if ($obj !== false) {
                        DoLog($this->object . " wurde hinzugefügt", LOG_LEVEL_INFO);
                        $view->assign("obj", $obj);
                        $view->changeMode("edit");
                    } else {
                        $view = new MessageView($this->object . " konnte nicht hinzugefügt werden.", LOG_LEVEL_SYSTEM_ERROR);
                    }
                } else {
                    $view->assign("obj", null);
                }
            } else if (($this->params[0] == "edit" || $this->IsReplaced("edit")) && isset($this->params[1]) && is_numeric($this->params[1])) {
                if (isset($this->request["edit"]) && $this->request["edit"] == "true") {
                    unset($this->request["edit"]);

                    $this->request["Id"] = $this->params[1];
                    $res = AddOrUpdate($this->table, $this->request);
                    if ($res)
                        DoLog($this->object . " wurde aktualisiert", LOG_LEVEL_INFO);
                    else
                        DoLog($this->object . " konnte nicht aktualisiert werden", LOG_LEVEL_SYSTEM_ERROR);
                }

                $obj = GetById($this->table, $this->params[1]);
                if ($obj !== false) {
                    $view->assign("obj", $obj);
                } else {
                    $view = new MessageView($this->object . " wurde nicht gefunden.", LOG_LEVEL_SYSTEM_ERROR);
                }
            } else if (($this->params[0] == "delete"  || $this->IsReplaced("edit")) && isset($this->params[1]) && is_numeric($this->params[1])) {
                if (isset($this->request["delete"]) && $this->request["delete"] == "true") {


                    $res = DeleteById($this->table, $this->params[1]);
                    if ($res) {
                        $view = new MessageView($this->object . " wurde gelöscht", LOG_LEVEL_INFO);
                    } else
                        $view = new MessageView($this->object . " konnte nicht gelöscht werden.", LOG_LEVEL_SYSTEM_ERROR);
                }
                $obj = GetById($this->table, $this->params[1]);
                if ($obj !== false) {
                    $view->assign("obj", $obj);
                } else {
                    $view = new MessageView($this->object . " wurde nicht gefunden.", LOG_LEVEL_SYSTEM_ERROR);
                }
            } else {
                $view = $this->NotFound();
            }
        }

        return $view->loadTemplate();
    }
}