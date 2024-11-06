<?php

use rollun\logger\LifeCycleToken;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
/** @var \Laminas\ServiceManager\ServiceManager $container */
$container = require 'config/container.php';
\rollun\dic\InsideConstruct::setContainer($container);
$lifeCycleToken = LifeCycleToken::generateToken();
$container->setService(LifeCycleToken::class, $lifeCycleToken);

$processTracker = new \rollun\utils\FailedProcesses\Service\ProcessTracker();

$processTracker::storeProcessData($lifeCycleToken);