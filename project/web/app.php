<?php

# Инициализируем профайлер
xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
require '../vendor/autoload.php';

$app = new Core\App();
$app->run();
# Останавливаем профайлер после выполнения программы
$xhprof_data = xhprof_disable();
var_dump($xhprof_data);