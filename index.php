<?php

define("APPPATH", __DIR__.'/');

include APPPATH.'conf/config.php';
include APPPATH.'core/base.php';
include APPPATH.'core/db.php';
include APPPATH.'func/global.php';

$c = isset($_GET['c']) ? $_GET['c'] : 'index';
$a = isset($_GET['a']) ? $_GET['a'] : 'index';

$controllerFile = APPPATH.'controller/'.$c.'.php';
if (!file_exists($controllerFile)) {
    exit('controller exists');
}
include $controllerFile;
$cClass = new $c();
if (method_exists($cClass, $a) == false) {
    exit('action exists');
}
$cClass->$a();
