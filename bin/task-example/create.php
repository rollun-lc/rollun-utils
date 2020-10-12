<?php
error_reporting(E_ALL ^ E_USER_DEPRECATED ^ E_DEPRECATED);

chdir(dirname(dirname(__DIR__)));

if (!file_exists('vendor/autoload.php')) {
    chdir(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
}

(new \rollun\Callables\TaskExample\FileSummary())->runTaskProcess((int)$argv[1]);
