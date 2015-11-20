<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\DI;

use Nette\DI\CompilerExtension;
use OnlineClimbing\UI\Forms\ITranslatableFormFactory;


class OnlineClimbingExtension extends CompilerExtension
{

	public function beforeCompile()
	{
		foreach ($this->getContainerBuilder()->findByType(ITranslatableFormFactory::class) as $definition) {
			$definition->addSetup('setTranslator');
		}
	}

}
