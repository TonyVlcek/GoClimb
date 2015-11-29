<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules\BackendModule;

use OnlineClimbing\Modules\BasePresenter;


abstract class BaseAdminPresenter extends BasePresenter
{

	protected function init()
	{
		$this->applicationPartsManager->setAsBackend();
	}

}
