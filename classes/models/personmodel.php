<?php

/**
 * Created by PhpStorm.
 * User: FlorianAlexander
 * Date: 5/18/2015
 * Time: 7:44 PM
 */
class PersonModel
{

    public $Id;
    public $FirstName;
    public $LastName;
    public $AdressExtension;
    public $Street;
    public $Land;
    public $ZipCode;
    public $Place;
    public $TelPrivat;
    public $TelBusiness;
    public $Mobile;
    public $Email;
    public $BirthDate;
    public $Description;
    public $AdressAlertBool;
    public $WakeUpTime;
    public $FirstContactDateTime;

    function GetName()
    {
        $str = "";
        if ($this->LastName != "") {
            $str .= $this->LastName;
        }
        if ($this->FirstName != "") {
            $str .= " " . $this->FirstName;
        }
        if ($str == "")
            return "<unbekannter Name>";
        else
            return $str;
    }

    function GetPersonalIdentification()
    {
        if ($this->FirstName != "") {
            return $this->FirstName;
        }
        if ($this->LastName != "") {
            return $this->LastName;
        }
    }

    function GetIdentification()
    {
        return $this->GetName();
    }
}