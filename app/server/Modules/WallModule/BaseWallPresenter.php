<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Modules\WallModule;

use GoClimb\Modules\BasePresenter;


abstract class BaseWallPresenter extends BasePresenter
{

	protected function init()
	{
		$this->applicationPartsManager->setAsWallSite($this->getParameter('wall'));
	}

}
