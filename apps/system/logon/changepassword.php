<?php

include"../database/mysql.php";

$cookie_username = filter_input(INPUT_COOKIE, 'username', FILTER_DEFAULT);
$password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
$newpassword1 = filter_input(INPUT_POST, 'newpassword1', FILTER_DEFAULT);
$newpassword2 = filter_input(INPUT_POST, 'newpassword2', FILTER_DEFAULT);


$salt = 'aramokaramok..aramokaramok..aramokaramok..aramokaramok..';
$password_enc = hash('sha256', $salt . $password);
$newpassword_enc = hash('sha256', $salt . $newpassword1);

if ($newpassword1 == $newpassword2 && $newpassword2 != "") {
    $sql = "SELECT * from users WHERE username='" . $cookie_username . "' and password='" .$password_enc. "' ";
    $result = $mysqli->query($sql);
    if ($result) {
        $user_exist = $result->num_rows;
        if ($user_exist != 0) {
            $sql = "UPDATE users SET password ='" . $newpassword_enc . "' WHERE username='" . $cookie_username . "' and password='" . $password_enc . "'";
            $resultchange = $mysqli->query($sql);
            if ($resultchange) {
                $return = 1;//password changed
            } else {
                $return = 2;//querror
            }
        }else{
            $return = 3;//user not found
        }
    }else{
        $return = 2;//querror
    }
      
} else {
    $return = 0;//pass dont match
}

echo $return;
