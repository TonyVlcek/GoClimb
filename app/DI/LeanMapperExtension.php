<?php
/**
 * @author Tomáš Blatný
 */

namespace App\DI;

use LeanMapper\Connection;
use LeanMapper\DefaultEntityFactory;
use LeanMapper\DefaultMapper;
use Nette\DI\CompilerExtension;
use Nette\DI\ContainerBuilder;


class LeanMapperExtension extends CompilerExtension
{
	public $defaults = [
		'mapper' => DefaultMapper::class,
		'entityFactory' => DefaultEntityFactory::class,
		'connection' => Connection::class,
		'host' => 'localhost',
		'driver' => 'mysqli',
		'username' => NULL,
		'password' => NULL,
		'database' => NULL,
		'lazy' => TRUE,
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$useProfiler = isset($config['profiler'])
			? $config['profiler']
			: class_exists('Tracy\Debugger') && $builder->parameters['debugMode'];
		unset($config['profiler']);

		$connection = $this->configureConnection($builder, $config);

		$builder->addDefinition($this->prefix('entityFactory'))
			->setClass($config['entityFactory']);

		$builder->addDefinition($this->prefix('mapper'))
			->setClass($config['mapper']);

		if ($useProfiler) {
			$panel = $builder->addDefinition($this->prefix('panel'))
				->setClass('Dibi\Bridges\Tracy\Panel');
			$connection->addSetup([$panel, 'register'], [$connection]);
		}
	}


	protected function configureConnection(ContainerBuilder $builder, array $config)
	{
		if (!isset($config['connection']) || !is_string($config['connection'])) {
			throw new \RuntimeException('Connection class definition is missing, or not (string).');
		}

		return $builder->addDefinition($this->prefix('connection'))
			->setClass($config['connection'], [
				[
					'host' => $config['host'],
					'driver' => $config['driver'],
					'username' => $config['username'],
					'password' => $config['password'],
					'database' => $config['database'],
					'lazy' => (bool) $config['lazy'],
				],
			]);
	}
}
