<?php

namespace GoClimb\Modules\PublicModule;

use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Facades\WallFacade;


final class DashboardPresenter extends BasePublicPresenter
{

	/** @var WallFacade */
	private $wallFacade;

	/** @var Wall[] */
	private $walls;


	public function __construct(WallFacade $wallFacade)
	{
		parent::__construct();
		$this->wallFacade = $wallFacade;
	}


	public function actionDefault()
	{
		$this->walls = $this->wallFacade->getAllWalls();
	}


	public function renderDefault()
	{
		$this->template->walls = $this->walls;
	}

}
