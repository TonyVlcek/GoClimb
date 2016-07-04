<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

class DashboardPresenter extends BaseV1Presenter
{

	public function actionDefault()
	{
		$this->payload->wall = [
			'id' => $this->wall->getId(),
			'name' => $this->wall->getName(),
		];
	}

}