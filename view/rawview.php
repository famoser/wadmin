<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 09.09.2015
 * Time: 23:44
 */
class RawView
{
    protected $path = null;
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function loadTemplate()
    {
        ob_start();

        include $_SERVER['DOCUMENT_ROOT'] . $this->path;
        $output = ob_get_contents();
        $output = sanitize_output($output);
        ob_end_clean();

        return $output;
    }
}