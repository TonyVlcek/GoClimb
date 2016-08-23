<?php

$container = require __DIR__ . '/../app/bootstrap.php';
$class = PHP_SAPI === 'cli' ? Kdyby\Console\Application::class : Nette\Application\Application::class;
$container->getByType($class)->run();
