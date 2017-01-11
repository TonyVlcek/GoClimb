<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Updaters;


use GoClimb\Model\Entities\Rope;
use GoClimb\Model\Repositories\ColorRepository;
use GoClimb\Model\Repositories\DifficultyRepository;
use GoClimb\Model\Repositories\LineRepository;
use GoClimb\Model\Repositories\ParameterRepository;
use GoClimb\Model\Repositories\RopeRepository;
use GoClimb\Model\Repositories\RouteParameterRepository;
use GoClimb\Model\Repositories\SectorRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Rest\Utils;
use stdClass;


class RopeUpdater extends RouteUpdater
{

	/** @var RopeRepository */
	private $ropeRepository;


	public function __construct(RopeRepository $ropeRepository, LineRepository $lineRepository, SectorRepository $sectorRepository, DifficultyRepository $difficultyRepository, ColorRepository $colorRepository, ParameterRepository $parameterRepository, RouteParameterRepository $routeParameterRepository, UserRepository $userRepository)
	{
		$this->ropeRepository = $ropeRepository;
		parent::__construct($lineRepository, $sectorRepository, $difficultyRepository, $colorRepository, $parameterRepository, $routeParameterRepository, $userRepository);
	}


	/**
	 * @param Rope $rope
	 * @param stdClass $data
	 * @return Rope
	 */
	public function updateRope(Rope $rope, stdClass $data)
	{
		$this->updateRoute($rope, $data);

		Utils::updateProperties($rope, $data, [
			'length' => FALSE,
			'steps' => FALSE,
		]);

		$this->ropeRepository->save($rope);
		return $rope;
	}

}
