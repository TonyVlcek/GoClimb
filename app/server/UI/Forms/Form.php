<?php

namespace GoClimb\UI\Forms;

use Nette\Application\UI\Form as NetteForm;
use Nette\Forms\Controls\BaseControl;


class Form extends NetteForm
{

	/**
	 * @param string $name
	 * @return BaseControl
	 */
	public function offsetGet($name)
	{
		return parent::offsetGet($name);
	}

}
