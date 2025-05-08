<?php

use Psr\Log\LoggerInterface;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';
\rollun\dic\InsideConstruct::setContainer($container);

/**
 * @var $logger LoggerInterface
 */
$logger = $container->get(LoggerInterface::class);
$logger->info("Test message", ["test" => "asdasd"]);
