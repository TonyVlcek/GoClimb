<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

class DashboardPresenter extends BaseV1Presenter
{

	public function actionGet()
	{
		$this->addData('wall', [
			'id' => $this->wall->getId(),
			'name' => $this->wall->getName(),
		]);
	}

}
