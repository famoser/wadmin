<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 10:33
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/services/adminservice.php";

class SettingsController extends ControllerBase
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
        $view = $this->NotFound();
        if (count($this->params) == 0 || $this->params[0] == "") {
            $view = new GenericView("settings");
            if (isset($this->request["changepass"])) {
                if ($this->request["Password1"] == $this->request["Password2"]) {
                    if (CheckPassword($this->request["Password1"])) {
                        $params = array();
                        $params["Id"] = GetActiveUser()->Id;
                        $params["PasswordHash"] = $this->request["Password1"];
                        if (AddOrUpdate("admins", $params))
                            DoLog("Das Passwort wurde erfolgreich geändert", LOG_LEVEL_INFO);
                        else
                            DoLog("Das Passwort konnte nicht geändert werden", LOG_LEVEL_SYSTEM_ERROR);
                    } else {
                        //log was done by CheckAdminPass
                    }
                } else {
                    DoLog("Die beiden Passwörter stimmen nicht überein", LOG_LEVEL_USER_ERROR);
                }
                if ($this->request["no-replace"] == true) {
                    exit;
                }
            }
            $view->assign('admins', GetAllOrderedBy("admins", "Id"));
        } else {
            $view = new GenericCrudView($this->params[0], array("deleteadmin" => "delete", "addadmin" => "add"), "settings", "admin");

            if ($this->params[0] == "addadmin") {
                if (isset($this->request["addadmin"]) && $this->request["addadmin"] == "true") {
                    unset($this->request["addadmin"]);

                    $res = AddAdmin($this->request);

                    if ($res) {
                        $obj = GetById("admins", $res);
                        if ($obj !== false) {
                            DoLog("Admin wurde hinzugefügt, E-Mail wurde versendet.", LOG_LEVEL_INFO);
                        } else {
                            DoLog("Admin wurde hinzugefügt, E-Mail wurde versendet.", LOG_LEVEL_SYSTEM_ERROR);
                        }
                    }
                }
                $view->assign("persons", GetAllOrderedBy("persons", "LastName, FirstName"));
                $view->assign("obj", null);
            } else if ($this->params[0] == "deleteadmin" && isset($this->params[1]) && is_numeric($this->params[1])) {
                if (isset($this->request["delete"]) && $this->request["delete"] == "true") {
                    $res = DeleteById("admins", $this->params[1]);
                    if ($res) {
                        $view = new MessageView("Admin wurde gelöscht", LOG_LEVEL_INFO);
                    } else
                        $view = new MessageView("Admin konnte nicht gelöscht werden.", LOG_LEVEL_SYSTEM_ERROR);
                } else {
                    $obj = GetById("admins", $this->params[1]);
                    if ($obj !== false) {
                        $obj->Person = GetById("persons", $obj->PersonId);
                        $view->assign("obj", $obj);
                    } else {
                        $view = new MessageView("Admin wurde nicht gefunden.", LOG_LEVEL_SYSTEM_ERROR);
                    }
                }
            }
        }
        return $view->loadTemplate();
    }
}