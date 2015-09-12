<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 08.09.2015
 * Time: 20:32
 */

class ControllerBase
{
    function NotFound()
    {
        return new MessageView("Seite nicht gefunden", LOG_LEVEL_USER_ERROR, 404);
    }

    function AccessDenied()
    {
        return new MessageView("Sie haben kein Zugriff auf diese Seite", LOG_LEVEL_USER_ERROR, 403);
    }
}