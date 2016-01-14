<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\DI;

use Nette\DI\CompilerExtension;
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use OnlineClimbing\Routing\ModularRouter;
use OnlineClimbing\UI\Controls\ITranslatableControlFactory;
use OnlineClimbing\UI\Forms\ITranslatableFormFactory;
use OnlineClimbing\UI\Grids\ITranslatableGridFactory;


class OnlineClimbingExtension extends CompilerExtension
{

	private $defaults = [
		'routers' => []
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);

		Validators::assert($config, 'array');
		Validators::assertField($config, 'routers', 'array');
	}


	public function beforeCompile()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$modularRouter = $builder->getDefinition('routing.router')
				->setClass(ModularRouter::class)
				->setFactory(NULL);

		foreach ($config['routers'] as $module => $router) {
			$definition = $builder->addDefinition($this->prefix(str_replace('-', '.', Strings::webalize($module . '-' . $router))))
					->setClass($router);
			$modularRouter->addSetup('addRouterProvider', [$module, $definition]);
		}

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
