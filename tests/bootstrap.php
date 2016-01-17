<?php
/**
 * @author Tomáš Blatný
 */

use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\Locker;
use Nette\DI\Container;
use Tester\Environment;
use Tester\TestCase;


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/utils/loader.php';

Environment::setup();
date_default_timezone_set('Europe/Prague');

$appDir = __DIR__ . '/../app';
$tempDir = __DIR__ . '/temp';

Locker::$path = $tempDir . '/locks';

define('DATA_DIR', __DIR__ . '/data');

if (!is_dir($tempDir . '/locks')) {
	mkdir($tempDir . '/locks', 0777, TRUE);
};

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
$configurator->setTempDirectory($tempDir);
$configurator->createRobotLoader()
	->addDirectory($appDir)
	->register();
$configurator->addConfig($appDir . '/config/config.neon');
if (file_exists($localConfig = $appDir . '/config/config.local.neon')) {
	$configurator->addConfig($localConfig);
}
$configurator->addConfig(__DIR__ . '/config/tests.neon');

$configurator->addParameters([
	'appDir' => $appDir,
]);

/** @var Container $container */
$container = $configurator->createContainer();

Helpers::$container = $container;

function testCase($className)
{
	if (is_object($className) && $className instanceof TestCase) { // back compatibility
		$className->run();
	} else {
		Helpers::runTestCase($className);
	}
}

return $container;
