<?php
$cookie_name    = filter_input(INPUT_POST, "name", FILTER_DEFAULT);
$cookie_value   = filter_input(INPUT_POST, "value", FILTER_DEFAULT);
$cookie_days    = filter_input(INPUT_POST, "days", FILTER_DEFAULT);

$result = setcookie('username', 'testcookie', time() + (86400 * $cookie_days), "/"); // 86400 = 1 day
echo ($result)?'created':'failed';

