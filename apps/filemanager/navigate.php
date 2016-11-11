<script>
    $(document).ready(function(){
        features_init();
        feature_draggable();
    });
</script>
<?php

include '../../kernel.php';
$directory = filter_input(INPUT_POST, "directory", FILTER_DEFAULT);
$window_id = filter_input(INPUT_POST, "window_id", FILTER_DEFAULT);
$username = filter_input(INPUT_COOKIE, 'username', FILTER_DEFAULT);


$filereader = new FIO();
$UI = new UI_manager($filereader);
$icons = $filereader->list_dir($directory);

//depletion need here
$level = count(split('/',str_replace(ABSPATH,'',$directory.'/')));

if (strpos($directory.'/', ABSPATH) !== false || isset($username)) {
    echo $UI->draw_icons($icons,$theme, 0 , $window_id);
}else{
    echo 'Forbidden';
}


