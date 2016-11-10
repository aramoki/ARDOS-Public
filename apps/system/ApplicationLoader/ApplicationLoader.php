<?php
error_reporting(0);
class ApplicationLoader {
    
}

include '../../../kernel.php';


function shutdown() {
    include ABSPATH.'apps/system/dialog/dialog.php';
    $window_id = filter_input(INPUT_POST, "window_id", FILTER_DEFAULT);
    $error = error_get_last();
    if ($error['type'] === E_ERROR || $error['type'] === E_WARNING || $error['type'] === E_NOTICE) {
        $UI = new UI_manager();
        
        $error_dialog = new dialog(3,$window_id);
        $UI->draw_window($error_dialog,$theme);  
    } 
}

register_shutdown_function('shutdown');


$UI = new UI_manager();

$window_id = filter_input(INPUT_POST, "window_id", FILTER_DEFAULT);
$app_name = filter_input(INPUT_POST, "app_name", FILTER_DEFAULT);
$file = filter_input(INPUT_POST, "file", FILTER_DEFAULT);
$app_path = filter_input(INPUT_POST, "app_path", FILTER_DEFAULT);


//$app_path = str_replace($_SERVER["DOCUMENT_ROOT"] . '/aramok', '', $app_path);

//$app_path = 'apps/'.$app_name;

$application = $UI->load_app($app_path, $app_name, $window_id, $file);
if (isset($application)) {
    $UI->draw_window($application,$theme);
} else {
    echo 'aplicationloader.php error application not defined';
}
?>