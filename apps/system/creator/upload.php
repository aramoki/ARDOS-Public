<?php

print_r($_FILES['files']);
print_r($_POST);

$target_Path = $_POST['path'].'/';
$target_Path = $target_Path.basename( $_FILES['files']['name'] );
$result = move_uploaded_file( $_FILES['files']['tmp_name'], $target_Path);

if($result){
    echo 'uploaded';
}else{
    echo 'not uploaded';
}
