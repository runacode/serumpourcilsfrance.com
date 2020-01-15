<?php


$data = json_decode(file_get_contents(dirname(__FILE__) . '/config/data.json'));
$product = $data->products[0];
include_once(dirname(__FILE__) . '/../locale/languages.php');


?>
