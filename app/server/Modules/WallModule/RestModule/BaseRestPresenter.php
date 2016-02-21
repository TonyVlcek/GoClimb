<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule;

use GoClimb\Modules\WallModule\BaseWallPresenter;


class BaseRestPresenter extends BaseWallPresenter
{

	public function beforeRender()
	{
		$this->sendPayload();
	}

}
