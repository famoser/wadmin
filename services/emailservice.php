<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 15:11
 */

function SendMail($to, $toname, $betreff, $message)
{
    IncludeIfNecessary("/libraries/PHPMailer.php");
    return SendEmailFromServer($to, $toname, $betreff, $message);
}
