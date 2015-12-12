<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules\BackendModule;

use OnlineClimbing\Modules\BasePresenter;


abstract class BaseBackendPresenter extends BasePresenter
{

	protected function init()
	{
		$this->applicationPartsManager->setAsBackend();
	}

}
