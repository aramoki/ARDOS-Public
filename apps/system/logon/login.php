<?php
$username = filter_input(INPUT_POST, "username", FILTER_DEFAULT);
$password = filter_input(INPUT_POST, "password", FILTER_DEFAULT);


$return = '';
$return .= $username.',';
$return .= $password.',';

if($username == "aramok" &$password =="aramok"){
    $return .= 'true,';
}else{
    $return .= 'false,';
}

echo $return;
?>