<?php
if(!defined('ABSPATH')){
    define('ABSPATH', dirname(__FILE__) . '/');
}

if(!defined('ABSDIR')){
    define('ABSDIR', str_replace(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').'/','', dirname(__FILE__)));
}


include ABSPATH.'apps/system/Application/Application.php';
include ABSPATH.'apps/system/ThemeManager/ThemeManager.php';
include ABSPATH.'apps/system/desktop/desktop.php';
include ABSPATH.'apps/system/UI_Manager/UI_Manager.php';
include ABSPATH.'apps/system/FIO/FIO.php';


date_default_timezone_set('Europe/Istanbul');

$theme = new ThemeManager();
$theme ->set_theme();


