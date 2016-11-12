<?php

include"../database/mysql.php";

$cookie_username = filter_input(INPUT_COOKIE, 'username', FILTER_DEFAULT);

$filteredpost = $_POST;
$updatefields = '';
$last_key = end(array_keys($filteredpost));
foreach ($filteredpost as $key => $value) {
    $updatefields .= $key . '=\''.$value.'\'' ;
    if ($key !== $last_key) {
      $updatefields .= ',' ; 
    } 
    
}
$sql = "UPDATE users SET ".$updatefields." WHERE username='".$cookie_username."'";

$result = $mysqli->query($sql);
if ($result) {
    echo 'successefully updated';
}