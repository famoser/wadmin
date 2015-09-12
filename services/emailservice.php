<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 15:11
 */

function SendMail($to, $betreff, $message)
{
    return mail($to, $betreff, $message, "Content-Type: text; charset=UTF-8");
}
