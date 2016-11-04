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


$filereader = new file_manager();
$UI = new UI_manager($filereader);
$icons = $filereader->list_dir($directory);
//print_r($icons);

echo $UI->draw_icons($icons, 0 , $window_id);
