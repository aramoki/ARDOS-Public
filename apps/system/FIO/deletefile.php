<?php

include 'FIO.php';

$file = filter_input(INPUT_POST, "file", FILTER_DEFAULT);
$f = new FIO();
echo $f->delete_file($file);

?>