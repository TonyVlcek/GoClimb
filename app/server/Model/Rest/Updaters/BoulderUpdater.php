<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Updaters;


use GoClimb\Model\Entities\Boulder;
use GoClimb\Model\Repositories\ColorRepository;
use GoClimb\Model\Repositories\DifficultyRepository;
use GoClimb\Model\Repositories\LineRepository;
use GoClimb\Model\Repositories\ParameterRepository;
use GoClimb\Model\Repositories\BoulderRepository;
use GoClimb\Model\Repositories\RouteParameterRepository;
use GoClimb\Model\Repositories\SectorRepository;
use GoClimb\Model\Rest\Utils;
use stdClass;


class BoulderUpdater extends RouteUpdater
{

	/** @var BoulderRepository */
	private $boulderRepository;


	public function __construct(BoulderRepository $boulderRepository, LineRepository $lineRepository, SectorRepository $sectorRepository, DifficultyRepository $difficultyRepository, ColorRepository $colorRepository, ParameterRepository $parameterRepository, RouteParameterRepository $routeParameterRepository)
	{
		$this->boulderRepository = $boulderRepository;
		parent::__construct($lineRepository, $sectorRepository, $difficultyRepository, $colorRepository, $parameterRepository, $routeParameterRepository);
	}


	/**
	 * @param Boulder $boulder
	 * @param stdClass $data
	 * @return Boulder
	 */
	public function updateBoulder(Boulder $boulder, stdClass $data)
	{
		$this->updateRoute($boulder, $data);

		Utils::updateProperties($boulder, $data, [
			'start' => FALSE,
			'end' => FALSE,
		]);

		$this->boulderRepository->save($boulder);
		return $boulder;
	}

}
