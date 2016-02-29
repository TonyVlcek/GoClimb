<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\BackendModule;

use GoClimb\Modules\BasePresenter;
use Nette\Application\Request;


abstract class BaseBackendPresenter extends BasePresenter
{

	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsBackend();
	}

}
