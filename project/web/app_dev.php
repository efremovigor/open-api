<?php
setlocale(LC_CTYPE, array('ru_RU.utf8', 'ru_UA.utf8'));
setlocale(LC_ALL, array('ru_RU.utf8', 'ru_UA.utf8'));
require '../app/autoload.php';
$kernel = new Kernel();
var_dump(preg_match('/^$/',';qwe=1'));