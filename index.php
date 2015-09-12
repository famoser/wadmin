<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 23.05.2015
 * Time: 10:00
 */


foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/common/*.php") as $filename)
{
    include_once $filename;
}

foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/controller/*.php") as $filename)
{
    include_once $filename;
}

foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/classes/models/*.php") as $filename)
{
    include_once $filename;
}

foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/view/*.php") as $filename)
{
    include_once $filename;
}

/* generics & commons */
include_once $_SERVER['DOCUMENT_ROOT'] . "/view/messageview.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/view/genericcrudview.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/view/genericview.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/services/genericservice.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/templates/partcreator.php";


session_start();

// $_GET und $_POST zusammenfasen
$request = array_merge($_GET, $_POST);
$requestFiles = $_FILES;

$arr = explode("/", $_SERVER['REQUEST_URI']);

//get controller
$params = array();
for ($i = 1; $i < count($arr); $i++) {
    $params[] = $arr[$i];
}

$allowedParams = [
    "persons",
    "export",
    "import",
    "settings"
];

define("ACTIVE_PARAMS", serialize($params));

$user = GetActiveUser();

if (in_array($params[0], $allowedParams) && $user !== false) {
    $controllerName = strtoupper(substr($params[0], 0, 1)) . substr($params[0], 1) . "Controller";
    $params = RemoveFirstEntryInArray($params);

    // Controller erstellen
    $controller = new $controllerName($request, $requestFiles, $params);
    // Inhalt der Webanwendung ausgeben.
    echo $controller->Display();
} else {
    if ($params[0] == "api")
    {
        $params = RemoveFirstEntryInArray($params);
        $controller = new ApiController($request, $requestFiles, $params);
        echo $controller->Display();
    }
    else {
        $controller = new MainController($request, $requestFiles, $params);
        // Inhalt der Webanwendung ausgeben.
        echo $controller->Display();
    }
}
?>
