<?php
include_once(__DIR__ . "/PHPMailer/PHPMailerAutoload.php");

function SendEmailFromServer($emails, $names, $subject, $message, $attachments = null, $additionalRecievers = null)
{
    $SendFromEmail = SERVER_EMAIL;
    $SendFromEmailPasswort = SERVER_EMAIL_PASSWORD;

    $ContactName = SERVER_EMAIL_RESPOND_NAME;
    $ContactEmail = SERVER_EMAIL_RESPOND_EMAIL;

    $Host = EMAIL_HOST;
    $smtpSecure = EMAIL_SECURE;
    $port = EMAIL_PORT;

    $mail = new PHPMailer;
    $mail->CharSet = 'utf-8';
    $mail->SetLanguage("de");
    $mail->isSMTP();
    $mail->Host = $Host;
    $mail->SMTPAuth = true;
    $mail->Username = $SendFromEmail;
    $mail->Password = $SendFromEmailPasswort;
    $mail->SMTPSecure = $smtpSecure;
    $mail->Port = $port;

    $mail->From = $SendFromEmail;
    $mail->FromName = $ContactName;

    if (!is_array($emails)) {
        if ($names != null)
            $mail->addAddress($emails, $names);
        else
            $mail->addAddress($emails, $emails);
    } else {
        for ($i = 0; $i < count($emails); $i++) {
            if ($names != null && is_array($names) && count($names) > $i)
                $mail->addAddress($emails[$i], $names[$i]);
            else
                $mail->addAddress($emails[$i], $emails[$i]);
        }
    }

    if ($additionalRecievers != null && is_array($additionalRecievers))
        foreach ($additionalRecievers as $addr) {
            $mail->addAddress($addr);
        }


    $mail->addReplyTo($ContactEmail, $ContactName);

    if ($attachments != null)
        for ($i = 0; $i < count($attachments); $i++) {
            $mail->AddAttachment($attachments[$i]);
        }

    $mail->isHTML(true);

    $mail->Subject = $subject;

    $mail->Body = nl2br($message);
    $mail->AltBody = $message;

    if ($mail->send()) {
        return true;
    }

    DoLog($mail->ErrorInfo);
    return false;
}

?>