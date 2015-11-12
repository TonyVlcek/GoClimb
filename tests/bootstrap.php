<?php
/**
 * @author Tomáš Blatný
 */

use Nette\DI\Container;
use Tester\Environment;


require __DIR__ . '/../vendor/autoload.php';

Environment::setup();
date_default_timezone_set('Europe/Prague');

$appDir = __DIR__ . '/../app';

$localBootstrap = $appDir . '/bootstrap.local.php';
if (file_exists($localBootstrap)) {
	require $localBootstrap;
}

$_SERVER = array_intersect_key($_SERVER, array_flip(['PHP_SELF', 'SCRIPT_NAME', 'SERVER_ADDR', 'SERVER_SOFTWARE', 'HTTP_HOST', 'DOCUMENT_ROOT', 'OS', 'argc', 'argv']));
$_SERVER['REQUEST_TIME'] = 1234567890;
$_ENV = $_GET = $_POST = [];

if (extension_loaded('xdebug')) {
	xdebug_disable();
}

$configurator = new Nette\Configurator;
$configurator->setDebugMode(FALSE);
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory($appDir)
	->register();
$configurator->addConfig($appDir . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/tests.neon');

$configurator->addParameters([
	'appDir' => $appDir,
]);

/** @var Container $container */
$container = $configurator->createContainer();

return $container;
