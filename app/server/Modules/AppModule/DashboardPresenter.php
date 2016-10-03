<?php

namespace GoClimb\Modules\AppModule;

use GoClimb\Model\Repositories\WallRepository;


class DashboardPresenter extends BaseAppPresenter
{

	/** @var WallRepository */
	private $wallRepository;


	public function __construct(WallRepository $wallRepository)
	{
		parent::__construct();
		$this->wallRepository = $wallRepository;
	}

	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->walls = $this->wallRepository->getAll();
	}
}
