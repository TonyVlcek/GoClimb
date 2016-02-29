<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Modules\PublicModule;

use GoClimb\Modules\BasePresenter;
use Nette\Application\Request;


abstract class BasePublicPresenter extends BasePresenter
{

	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsBackend();
	}

}
