<?php

include 'FIO.php';

$file = filter_input(INPUT_POST, "file", FILTER_DEFAULT);
$newfilename = filter_input(INPUT_POST, "newfilename", FILTER_DEFAULT);
$f = new FIO();
echo $f->rename_file($file,$newfilename);

//kim neyi rename etti log kayitlarina eklesin

?>