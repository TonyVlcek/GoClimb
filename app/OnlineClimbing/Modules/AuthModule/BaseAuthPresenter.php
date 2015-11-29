<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Modules\AuthModule;

use OnlineClimbing\Modules\BasePresenter;


abstract class BaseAuthPresenter extends BasePresenter
{

	protected function init()
	{
		$this->applicationPartsManager->setAsAuth();
	}

}
