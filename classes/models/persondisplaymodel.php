<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 23.05.2015
 * Time: 09:55
 */
class PersonDisplayModel {

    public $Id;
    public $Vornahme;
    public $Nachname;
    public $Adresswarnung;

    function GetName() {
        $str = "";
        if ($this->Nachname != "") {
            $str .= $this->Nachname;
        }
        if ($this->Vorname != "") {
            $str .= " " . $this->Vorname;
        }
        if ($str == "")
            return "<Dieses Mitglied hat weder Vorname noch Nachname>";
        else
            return $str;
    }
}