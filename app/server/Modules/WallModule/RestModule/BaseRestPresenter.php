<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule;

use GoClimb\Modules\WallModule\BaseWallPresenter;


abstract class BaseRestPresenter extends BaseWallPresenter
{

	public function beforeRender()
	{
		$this->sendPayload();
	}

}
