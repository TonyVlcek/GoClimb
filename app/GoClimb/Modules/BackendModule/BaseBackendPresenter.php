<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\BackendModule;

use GoClimb\Modules\BasePresenter;


abstract class BaseBackendPresenter extends BasePresenter
{

	protected function init()
	{
		$this->applicationPartsManager->setAsBackend();
	}

}
