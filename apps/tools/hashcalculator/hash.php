<?php

$string = filter_input(INPUT_POST, "string", FILTER_DEFAULT);
$type = filter_input(INPUT_POST, "type", FILTER_DEFAULT);

echo hash($type, $string,false);