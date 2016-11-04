<?php

$amount = filter_input(INPUT_POST, "amount", FILTER_DEFAULT);
$from = filter_input(INPUT_POST, "currency", FILTER_DEFAULT);
$to = filter_input(INPUT_POST, "convertto", FILTER_DEFAULT);

$url = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
$data = file_get_contents($url);
preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
$converted = preg_replace("/[^0-9.]/", "", $converted[1]);
echo round($converted, 3);
