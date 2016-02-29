<?php

namespace GoClimb\Modules\PublicModule;

use GoClimb\Modules\BasePresenter;
use GoClimb\NotImplementedException;
use Nette\Application\Request;


abstract class BasePublicPresenter extends BasePresenter
{

	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsBackend();
	}


	/**
	 * @inheritdoc
	 */
	protected function getApplicationToken()
	{
		throw new NotImplementedException;
	}

}
