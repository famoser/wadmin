<?php
/**
 * Created by PhpStorm.
 * User: FlorianAlexander
 * Date: 5/18/2015
 * Time: 7:44 PM
 */
class AdminModel {

    public $Id;
    public $PersonId;
    public $Email;
    public $PasswordHash;
    public $AuthHash;

    public $Person;

    function GetIdentification()
    {
        if ($this->Person != null) {
            return "Admin (".$this->Email."), verbunden mit " . $this->Person->GetIdentification();
        } else {
            return "Admin (".$this->Email.")";
        }
    }

    function GetPersonalIdentification()
    {
        if ($this->Person != null) {
            return $this->Person->GetPersonalIdentification();
        } else {
            return "Admin";
        }
    }
}