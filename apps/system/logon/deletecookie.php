<?php
$cookie_name    = filter_input(INPUT_POST, "name", FILTER_DEFAULT);
setcookie($cookie_name, '', time() + -1, '/');

