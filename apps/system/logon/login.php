<?php
include"../database/mysql.php";
$cookie_days = filter_input(INPUT_POST, "days", FILTER_DEFAULT);
$username = strip_tags($mysqli->real_escape_string(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS)));
$password = strip_tags($mysqli->real_escape_string(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS)));

$password_enc = hash('sha256', $password);

if ($username != "" && $password != "") {
    $sql = "SELECT * from users WHERE (username='" . $username . "' or email='" . $username . "') and password='" .$password. "' ";
    $result = $mysqli->query($sql);
    if ($result) {
        $user_exist = $result->num_rows;
        if ($user_exist != 0) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $expire = time() + 60 * 60 * 24 * 30;
            setcookie("user_id", $row['id'], $expire , "/");
            setcookie("username", $row['username'],$expire, "/");
            //print_r($row);
            $return = 1;// ok! come back home
        }else{
            $return = 2;//user not found
        }
    } else {
        $return = 3;// sql query error
    }
} else {
   $return = 4;//fields are empty
}
echo $return;





