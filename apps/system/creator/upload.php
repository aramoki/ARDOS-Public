<?php

$target_Path = $_POST['path'].'/';
$target_Path = $target_Path.basename( $_FILES['files']['name'] );
$result = move_uploaded_file( $_FILES['files']['tmp_name'], $target_Path);

if($result){
    echo $_FILES['files']['name'].' uploaded to '.$_POST['path'];
}else{
    echo $_FILES['files']['name'].' <b>not</b> uploaded path:'.$_POST['path'];

}
