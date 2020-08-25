<?php
error_reporting(E_ALL ^ E_USER_DEPRECATED ^ E_DEPRECATED);

chdir(dirname(dirname(__DIR__)));
require 'vendor/autoload.php';

use rollun\Callables\TaskExample\FileSummary;
use rollun\Callables\TaskExample\Model\CreateTaskParameters;

(new FileSummary())->runTask(new CreateTaskParameters((int)$argv[1]));
