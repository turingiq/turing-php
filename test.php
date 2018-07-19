<?php

require("vendor/autoload.php");
require("lib/VisualAPI.php");

$visual_api = new \Turing\VisualAPI("PtddkwjEm6fNCFbESrpYig", 'sandbox');
$resp = $visual_api->recommendations(8105, ['filter2'=> 'topwear']);
var_dump($resp);
