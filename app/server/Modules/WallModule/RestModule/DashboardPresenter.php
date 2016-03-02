<?php

namespace GoClimb\Modules\WallModule\RestModule;

class DashboardPresenter extends BaseRestPresenter
{

	public function actionDefault()
	{
		$this->payload->wall = [
			'id' => $this->wall->getId(),
			'name' => $this->wall->getName(),
		];
	}

}
