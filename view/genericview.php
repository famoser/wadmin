<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 01.07.2015
 * Time: 18:57
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/view/viewbase.php";

class GenericView extends ViewBase
{
    protected $controller = null;
    public function __construct($controller, $submenu = null, $title = null, $description = null)
    {
        $this->controller = $controller;
        parent::__construct($submenu, $title, $description);
    }

    public function loadTemplate()
    {
        ob_start();

        include $_SERVER['DOCUMENT_ROOT'] . "/templates/" . $this->controller . "controller/" . $this->controller . ".php";
        $output = ob_get_contents();
        $output = sanitize_output($output);
        ob_end_clean();

        return $output;
    }
}