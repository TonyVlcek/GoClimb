<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\DI;

use GoClimb\Routing\RouterFactory;
use GoClimb\UI\Controls\ITranslatableControlFactory;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use GoClimb\UI\Grids\ITranslatableGridFactory;
use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;


class GoClimbExtension extends CompilerExtension
{

	private $defaults = [
		'routes' => [
			'useVirtualHosts' => FALSE,
			'useHttps' => FALSE,
			'domains' => []
		]
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);

		Validators::assert($config, 'array');
		Validators::assertField($config, 'routes', 'array');

		Validators::assertField($config['routes'], 'useVirtualHosts', 'bool');
		Validators::assertField($config['routes'], 'useHttps', 'bool');
		Validators::assertField($config['routes'], 'domains', 'array');
	}


	public function beforeCompile()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$routerFactory = $builder->addDefinition($this->prefix('routerFactory'))
			->setClass(RouterFactory::class)
			->setArguments([
				$config['routes']['useVirtualHosts'],
				$config['routes']['useHttps'],
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

}
