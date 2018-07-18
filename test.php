<?php

require("vendor/autoload.php");
require("lib/Visual.php");

$visual = new \Turing\Visual("PtddkwjEm6fNCFbESrpYig");
$crops = $visual->autocrop("https://im.idiva.com/content/2015/Feb/thumbnail_idiva2.jp");

var_dump($crops);
