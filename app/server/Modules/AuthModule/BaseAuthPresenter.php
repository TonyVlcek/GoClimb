<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Modules\AuthModule;

use GoClimb\Modules\BasePresenter;
use Nette\Application\Request;


abstract class BaseAuthPresenter extends BasePresenter
{

	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsAuth();
	}

}
