<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 01.07.2015
 * Time: 18:50
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/view/genericview.php";

class GenericCrudView extends GenericView
{
    protected $link;
    protected $folder;
    protected $replaces;

    public function __construct($mode, $replaces, $controller, $folder = null, $submenu = null, $title = null, $description = null)
    {
        $this->replaces = $replaces;
        $this->link = $mode;
        $this->setMode($mode);

        if ($folder === null)
            $this->folder = "crud/";
        if ($folder === "")
            $this->folder = "";
        if (strlen($folder) > 0)
            $this->folder = $folder . "/";
        parent::__construct($controller, $submenu = null, $title = null, $description = null);
    }

    public function changeMode($newmode)
    {
        $this->setMode($newmode);
    }

    private function setMode($newmode)
    {
        if ($this->replaces != null && is_array($this->replaces) && isset($this->replaces[$newmode]))
            $this->mode = $this->replaces[$newmode];
        else
            $this->mode = $newmode;
        $this->assign("mode", $this->mode);
    }

    public function loadTemplate()
    {
        ob_start();
        if ($this->mode == "delete") {
            include $_SERVER['DOCUMENT_ROOT'] . "/templates/genericcontroller/crud/delete.php";
        } else {
            include $_SERVER['DOCUMENT_ROOT'] . "/templates/" . $this->controller . "controller/" . $this->folder . $this->mode . ".php";
        }
        $output = ob_get_contents();
        $output = sanitize_output($output);
        ob_end_clean();

        return $output;
    }
}