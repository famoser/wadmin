<?php

/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 23.05.2015
 * Time: 14:14
 */
class ViewBase
{
    /**
     * Enthält die Variablen, die in das Template eingebetet
     * werden sollen.
     */
    protected $_ = array();
    protected $page_title = DEFAULTTITLE;
    protected $page_description = DEFAULTDESCRIPTION;
    public $params = null;
    protected $submenu = null;

    public function __construct($submenu = null, $title = null, $description = null)
    {
        $this->params = unserialize(ACTIVE_PARAMS);

        if ($title != null)
            $this->page_title = $title;
        if ($description != null)
            $this->page_description = $description;
        if ($submenu != null)
            $this->submenu = $submenu;
    }

    /**
     * Ordnet eine Variable einem bestimmten Schl&uuml;ssel zu.
     *
     * @param String $key Schlüssel
     * @param String $value Variable
     */
    public function assign($key, $value)
    {
        $this->_[$key] = $value;
    }
}