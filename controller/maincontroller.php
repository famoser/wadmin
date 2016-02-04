<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 23.05.2015
 * Time: 13:51
 */

class MainController extends ControllerBase
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
        $user = GetActiveUser();
        $view = $this->NotFound();
        if (count($this->params[0]) < 2 && $this->params[0] == "") {
            if ($user !== false) {
                DoLog("Sie sind eingeloggt, und wurden automatisch weitergeleitet");
                header("Location: " . BASEURL . AFTER_LOGIN_PAGE. "/");
                exit;
            }

            if (isset($this->request["email"]) && isset($this->request["password"])) {
                $res = TryLogin($this->request["email"], $this->request["password"]);
                if ($res !== false) {
                    SetActiveUser($res);
                    $personal = $res->GetPersonalIdentification();
                    if ($personal != "")
                        $personal = ", ".$personal;
                    DoLog('Willkommen'.$personal.'!');
                    header("Location: " . BASEURL . AFTER_LOGIN_PAGE. "/");
                    exit;
                } else {
                    DoLog("Login fehlgeschlagen", LOG_LEVEL_USER_ERROR);
                    $view = new GenericCrudView("login", array(), "main", "login");
                    $view->assign("save", array("email" => $this->request["email"]));
                }
            } else {
                $view = new GenericCrudView("login", array(), "main", "login");
                $view->assign("save", null);
            }
        } else if ($this->params[0] == "activateAccount" && isset($this->params[1])) {
            if (isset($this->request["Password"]) && isset($this->request["Password1"])) {
                if ($this->request["Password"] == $this->request["Password1"]) {
                    if (CheckPassword($this->request["Password"])) {
                        $admin = GetSingleByCondition("admins", array("Id" => $this->request["Id"], "AuthHash" => $this->request["AuthHash"]));
                        if ($admin !== false) {
                            $params = array();
                            $params["Id"] = $this->request["Id"];
                            $params["PasswordHash"] = $this->request["Password"];
                            $params["AuthHash"] = "";
                            if (AddOrUpdate("admins", $params)) {
                                DoLog("Das Passwort wurde erfolgreich geändert");
                                SetActiveUser(GetById("admins", $admin->Id));
                                header("Location: " . BASEURL . AFTER_LOGIN_PAGE. "/");
                                exit;
                            } else
                                DoLog("Das Passwort konnte nicht geändert werden", LOG_LEVEL_SYSTEM_ERROR);
                        } else {
                            DoLog("Dieser Authetifizierungslink ist nicht mehr gültig", LOG_LEVEL_USER_ERROR);
                        }
                    } else {
                        //log was done by CheckAdminPass
                    }
                } else {
                    DoLog("Die beiden Passwörter stimmen nicht überein", LOG_LEVEL_USER_ERROR);
                }
            }

            if (strlen($this->params[1]) < 20 || strlen($this->params[1]) > 100)
                $view = new MessageView("Dieser Authentifizierungslink ist ungültig.", LOG_LEVEL_USER_ERROR);
            else {
                $res = GetSingleByCondition("admins", array("AuthHash" => $this->params[1]));
                if ($res !== false) {
                    $view = new GenericCrudView("addpass", array(), "main", "login");
                    $view->assign("admin", $res);
                } else {
                    $view = new MessageView("Dieser Authentifizierungslink ist ungültig. Wurde er schon benützt?", LOG_LEVEL_USER_ERROR);
                }
            }
        } else if ($this->params[0] == "forgotpass") {
            $view = new GenericCrudView("forgotpass", array(), "main", "login");
            if (isset($this->request["email"])) {
                DoLog("Ihnen wird eine E-Mail gesendet, falls die eingebene E-Mail mit der eines Admin Accounts übereinstimmt.", LOG_LEVEL_INFO);
                ResetAdminPassByEmail($this->request["email"]);
            }
        } else if ($this->params[0] == "logout") {
            RemoveActiveUser();
            DoLog("Logout erfolgreich", LOG_LEVEL_INFO);
            header("Location: " . BASEURL);
            exit;
        }

        return $view->loadTemplate();
    }
}