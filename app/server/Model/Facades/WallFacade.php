<?php

namespace GoClimb\Model\Facades;

use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\WallRepository;


class WallFacade
{

	/** @var WallRepository */
	private $wallRepository;


	public function __construct(WallRepository $wallRepository)
	{
		$this->wallRepository = $wallRepository;
	}


	/**
	 * @return Wall[]
	 */
	public function getAllWalls()
	{
		return $this->wallRepository->getAll();
	}

}
