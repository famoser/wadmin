<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 01.07.2015
 * Time: 09:36
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/view/viewbase.php";

class MessageView extends ViewBase
{
    protected $message;
    protected $loglevel;
    protected $httpHeader;
    protected $showLink;

    public function __construct($message, $loglevel = LOG_LEVEL_INFO, $httpCode = null, $showLink = true)
    {
        $this->message = $message;
        $this->loglevel = $loglevel;
        $this->httpHeader = $httpCode;
        $this->showLink = $showLink;
        parent::__construct();
    }

    /**
     * loads the template
     */
    public function loadTemplate()
    {
        if ($this->httpHeader == 404)
            header("HTTP/1.0 404 Not Found");
        if ($this->httpHeader == 403)
            header("HTTP/1.0 403 Forbidden");
        if ($this->httpHeader == 401)
            header("HTTP/1.1 401 Unauthorized");

        ob_start();

        include $_SERVER['DOCUMENT_ROOT'] . "/templates/maincontroller/message.php";;
        $output = ob_get_contents();
        $output = sanitize_output($output);
        ob_end_clean();

        return $output;
    }
}