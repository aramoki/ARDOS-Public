<?php

$cookie_name = filter_input(INPUT_POST, "name", FILTER_DEFAULT);
$cookie_value = filter_input(INPUT_COOKIE, $cookie_name, FILTER_DEFAULT);
if (isset($cookie_value)) {
    echo $cookie_value; // echo your json
} else {
    echo $cookie_value; // echo your json
}
return; // then return