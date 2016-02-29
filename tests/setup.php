<?php

use Kdyby\Console\Application;
use Kdyby\Doctrine\Connection;
use Kdyby\Doctrine\EntityManager;
use Nette\DI\Container;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;


require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/Prague');

$appDir = __DIR__ . '/../app';
$tempDir = __DIR__ . '/temp';

define('DATA_DIR', __DIR__ . '/data');

if (!is_dir($tempDir . '/locks')) {
	mkdir($tempDir . '/locks', 0777, TRUE);
};

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

/** @var Connection $connection */
$connection = $container->getByType(EntityManager::class)->getConnection();
$connection->prepare('SET foreign_key_checks = 0')->execute();
$statement = $connection->prepare('SHOW TABLES');
$statement->execute();
while ($table = $statement->fetchColumn(0)) {
	$connection->prepare('DROP TABLE ' . $table)->execute();
}

$cacheCommand = new ArrayInput([
	'command' => 'app:cache:clean',
	'--no-interaction',
]);
$migrateCommand = new ArrayInput([
	'command' => 'migrations:migrate',
	'--no-interaction',
	'--allow-no-migration',
]);
//$output = new BufferedOutput;

/** @var Application $application */
$application = $container->getByType(Application::class);
$application->run($cacheCommand, new NullOutput);
$application->run($migrateCommand, new NullOutput);
