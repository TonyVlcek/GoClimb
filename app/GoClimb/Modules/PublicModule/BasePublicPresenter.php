<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Modules\PublicModule;

use GoClimb\Modules\BasePresenter;


abstract class BasePublicPresenter extends BasePresenter
{

	protected function init()
	{
		$this->applicationPartsManager->setAsBackend();
	}

}
