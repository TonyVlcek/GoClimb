<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\Route;
use GoClimb\Model\Entities\RouteParameter;
use GoClimb\Model\Enums\Parameter;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\ColorRepository;
use GoClimb\Model\Repositories\DifficultyRepository;
use GoClimb\Model\Repositories\LineRepository;
use GoClimb\Model\Repositories\ParameterRepository;
use GoClimb\Model\Repositories\RouteParameterRepository;
use GoClimb\Model\Repositories\SectorRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Rest\Utils;
use stdClass;


abstract class RouteUpdater
{

	/** @var LineRepository */
	private $lineRepository;

	/** @var SectorRepository */
	private $sectorRepository;

	/** @var DifficultyRepository */
	private $difficultyRepository;

	/** @var ColorRepository */
	private $colorRepository;

	/** @var ParameterRepository */
	private $parameterRepository;

	/** @var RouteParameterRepository */
	private $routeParameterRepository;

	/** @var UserRepository */
	private $userRepository;

	public function __construct(LineRepository $lineRepository, SectorRepository $sectorRepository, DifficultyRepository $difficultyRepository, ColorRepository $colorRepository, ParameterRepository $parameterRepository, RouteParameterRepository $routeParameterRepository, UserRepository $userRepository)
	{
		$this->lineRepository = $lineRepository;
		$this->sectorRepository = $sectorRepository;
		$this->difficultyRepository = $difficultyRepository;
		$this->colorRepository = $colorRepository;
		$this->parameterRepository = $parameterRepository;
		$this->routeParameterRepository = $routeParameterRepository;
		$this->userRepository = $userRepository;
	}


	/**
	 * @param Route $route
	 * @param stdClass $data
	 * @return Route
	 */
	protected function updateRoute(Route $route, stdClass $data)
	{
		if (!$data) {
			throw MappingException::invalidData();
		}

		// name, description
		Utils::updateProperties($route, $data, [
			'name' => TRUE,
			'description' => FALSE,
		]);

		// sector && line
		Utils::checkProperty($data, 'sector', TRUE);
		if (!$sector = $this->sectorRepository->getById($data->sector->id)) {
			throw MappingException::invalidId('sector');
		}

		Utils::checkProperty($data, 'line', TRUE);
		if (!$line = $this->lineRepository->getById($data->line->id)) {
			throw MappingException::invalidId('line');
		}
		if ($line->getSector() !== $sector) {
			throw MappingException::invalidRelation('line', $line->getId());
		}
		$route->setLine($line);

		// difficulty
		Utils::checkProperty($data, 'difficulty', TRUE);

		if (!$difficulty = $this->difficultyRepository->getById($data->difficulty->id)) {
			throw MappingException::invalidId('difficulty');
		}
		$route->setDifficulty($difficulty);

		// dateCreated, dateRemoved
		Utils::checkProperty($data, 'dateCreated', FALSE);
		$route->setDateCreated(Utils::toDateTime($data->dateCreated));
		Utils::checkProperty($data, 'dateRemoved', FALSE);
		$route->setDateCreated(Utils::toDateTime($data->dateRemoved));

		// colors
		Utils::checkProperty($data, 'colors', TRUE);
		$colors = [];
		foreach ((array) $data->colors as $hash) {
			if (!$color = $this->colorRepository->getGlobalByHash($hash)) {
				throw MappingException::invalidRelation('color', $hash);
			}
			$colors[] = $color;
		}
		$route->setColors($colors);

		// parameters
		Utils::checkProperty($data, 'parameters', TRUE);
		$routeParameters = [];
		foreach ((array) $data->parameters as $routeParameter) {
			Utils::checkProperty($routeParameter, 'level', TRUE);
			$level = (int) $routeParameter->level;
			if (!in_array($level, RouteParameter::getAllowedLevels(), TRUE)) {
				throw MappingException::invalidValue('level', $level);
			}

			Utils::checkProperty($routeParameter, 'parameter', TRUE);
			if (!Parameter::isValid($routeParameter->parameter) || !$parameter = $this->parameterRepository->getByName($routeParameter->parameter)) {
				throw MappingException::invalidValue('parameters.parameter', $routeParameter->parameter);
			}

			$routeParameters[] = $this->routeParameterRepository->setRouteParameter($route, $parameter, $level);
		}

		foreach ($route->getRouteParameters() as $routeParameter) {
			if (!in_array($routeParameter, $routeParameters, TRUE)) {
				$route->removeRouteParameter($routeParameter);
			}
		}

		// user
		Utils::checkProperty($data, 'builder', TRUE);
		$route->setBuilder($this->userRepository->getById($data->builder->id));

		// done
		return $route;
	}

}
