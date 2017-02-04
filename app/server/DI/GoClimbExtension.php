<?php

namespace GoClimb\DI;

use GoClimb\Routing\RouterFactory;
use GoClimb\UI\Controls\ITranslatableControlFactory;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use GoClimb\UI\Grids\ITranslatableGridFactory;
use GoClimb\UI\CdnLinkGenerator;
use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;
use server\DI\Labels\LabelsGenerator;


class GoClimbExtension extends CompilerExtension
{

	private $defaults = [
		'routes' => [
			'useVirtualHosts' => FALSE,
			'domains' => [],
		],
	];

	private $tempDir;


	/**
	 * GoClimbExtension constructor.
	 *
	 * @param $tempDir
	 */
	public function __construct($tempDir)
	{
		$this->tempDir = $tempDir;
	}


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);

		Validators::assert($config, 'array');
		Validators::assertField($config, 'routes', 'array');
		Validators::assertField($config, 'cdnUrl', 'string');

		Validators::assertField($config['routes'], 'useVirtualHosts', 'bool');
		Validators::assertField($config['routes'], 'domains', 'array');

		Validators::assertField($config, 'labels', 'array');
		Validators::assertField($config['labels'], 'zoom', 'number');
	}


	public function beforeCompile()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition('imageLinkGenerator')
			->setClass(CdnLinkGenerator::class)
			->setArguments([$this->getCdnUrl()]);

		$builder->addDefinition('labelsGenerator')
			->setClass(LabelsGenerator::class)
			->setArguments([
				$config['labels']['zoom'],
				$this->tempDir
			]);

		$routerFactory = $builder->addDefinition($this->prefix('routerFactory'))
			->setClass(RouterFactory::class)
			->setArguments([
				$config['routes']['useVirtualHosts'],
				$config['routes']['domains'],
			])
			->addSetup('injectFilters');

		$builder->getDefinition('routing.router')
			->setFactory([$routerFactory, 'create']);

		foreach ($this->getContainerBuilder()->findByType(ITranslatableControlFactory::class) as $definition) {
			$definition->addSetup('setTranslator');
		}

		foreach ($this->getContainerBuilder()->findByType(ITranslatableFormFactory::class) as $definition) {
			$definition->addSetup('setTranslator');
		}

		foreach ($this->getContainerBuilder()->findByType(ITranslatableGridFactory::class) as $definition) {
			$definition->addSetup('setTranslator');
		}
	}


	private function getCdnUrl()
	{
		$config = $this->getConfig($this->defaults);
		return substr($config['cdnUrl'], -1) === '/' ? $config['cdnUrl'] : $config['cdnUrl'] . '/';
	}

}
