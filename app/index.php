<?php
require_once __DIR__.'/../config/bootstrap.php';

$action = $_GET['action'] ?? 'index';
$controller = $_GET['controller'] ?? 'prato';

$controllerClass = ucfirst($controller).'Controller';
require_once __DIR__."/controllers/$controllerClass.php";

$controllerInstance = new $controllerClass();
$controllerInstance->$action();