<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Modules\AuthModule;

use GoClimb\Modules\BasePresenter;


abstract class BaseAuthPresenter extends BasePresenter
{

	protected function init()
	{
		$this->applicationPartsManager->setAsAuth();
	}

}
