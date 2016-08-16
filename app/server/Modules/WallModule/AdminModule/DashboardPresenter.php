<?php

namespace GoClimb\Modules\WallModule\AdminModule;

class DashboardPresenter extends BaseAdminPresenter
{


	public function renderDefault()
	{
		$this->template->locale = $this->locale;
	}

}
