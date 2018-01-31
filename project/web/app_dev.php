<?php

require '../app/autoload.php';
$kernel = new Kernel();
$parser = new YmlParser();

var_dump($parser->getYml($kernel->getAppDir().'/config/services.yml'));