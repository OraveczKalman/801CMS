<?php
session_start();
date_default_timezone_set('Europe/Budapest');
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $_SESSION['prefix'] = 'https';
} else {
    $_SESSION['prefix'] = 'http';
}
include_once('./application/common/PathConfig.php');
$db=null;
if (file_exists(CORE_PATH . "DbConfig.json")) {
    $databaseConfig[0] = json_decode(file_get_contents(CORE_PATH . "DbConfig.json"), true);
    include_once(CORE_PATH . "DbCore.php"); 
    $db = new DbCore($databaseConfig[0]);
    if (!isset($_SESSION['setupData'])) {
        include_once(DATABASE_PATH . 'SetupModel.php');
        $setupData = SetupModel::getSetupData(1, $db);
        $_SESSION['setupData'] = json_decode($setupData[0]['SetupData'], true);
    }
    if (!isset($_REQUEST['event'])) {
        $_REQUEST['event'] = '';
    }
} else {
    $_SERVER['REQUEST_URI'] .= 'setup';
}

include_once(CORE_PATH . 'Routing.php');
$uriExploded = explode('?', $_SERVER['REQUEST_URI']);
$route = new Router($uriExploded[0], $_SERVER['SCRIPT_NAME'], $db);