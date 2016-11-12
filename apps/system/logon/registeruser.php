<?php
include"../database/mysql.php";

$username = filter_input(INPUT_POST, "username", FILTER_DEFAULT);
$password1 = filter_input(INPUT_POST, "password", FILTER_DEFAULT);
$password2 = filter_input(INPUT_POST, "password2", FILTER_DEFAULT);
$email = filter_input(INPUT_POST, "email", FILTER_DEFAULT);
$aggrement = filter_input(INPUT_POST, "aggrement", FILTER_DEFAULT);



if($aggrement == 'on'){
    if($password1 == $password2 && $username!='' && $password1 !='' && $email !='' ){
        $salt = 'aramokaramok..aramokaramok..aramokaramok..aramokaramok..';
        $password_enc = hash('sha256', $salt . $password1);
        
        $sql = "SELECT * from users WHERE (username='" . $username . "' or email='" . $email . "') ";
        $result = $mysqli->query($sql);
        if ($result) {
            $user_exist = $result->num_rows;
            if ($user_exist == 0) {
                $sqlreg = "INSERT INTO users (username, password, email) VALUES ('".$username."','".$password_enc."','".$email."')";
                 $resultreg = $mysqli->query($sqlreg);
                if ($resultreg) {
                    $return = 0;
                }else{
                    $return = 3; // sql query error
                }
            } else {
                $return = 2; //user or mail exist
            }
        } else {
            $return = 3; // sql query error
        }
    }else{
        $return = 4;//not proper fields
    }
}else{
    $return = 1;//aggrement on 
}

echo $return;