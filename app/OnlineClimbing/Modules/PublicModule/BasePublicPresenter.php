<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Modules\PublicModule;

use OnlineClimbing\Modules\BasePresenter;


abstract class BasePublicPresenter extends BasePresenter
{

	protected function init()
	{
		$this->applicationPartsManager->setAsBackend();
	}

}
