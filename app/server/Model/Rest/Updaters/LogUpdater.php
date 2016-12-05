<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\Log;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\BoulderRepository;
use GoClimb\Model\Repositories\LogRepository;
use GoClimb\Model\Repositories\RopeRepository;
use GoClimb\Model\Repositories\RouteRepository;
use GoClimb\Model\Repositories\StyleRepository;
use GoClimb\Model\Rest\Utils;
use stdClass;
use Tracy\Debugger;


class LogUpdater
{

	/** @var LogRepository */
	private $logRepository;

	/** @var RopeRepository */
	private $ropeRepository;

	/** @var BoulderRepository */
	private $boulderRepository;

	/** @var StyleRepository */
	private $styleRepository;


	public function __construct(LogRepository $logRepository, RopeRepository $ropeRepository, BoulderRepository $boulderRepository, StyleRepository $styleRepository)
	{
		$this->logRepository = $logRepository;
		$this->ropeRepository = $ropeRepository;
		$this->boulderRepository = $boulderRepository;
		$this->styleRepository = $styleRepository;
	}


	/**
	 * @param Log $log
	 * @param stdClass $data
	 * @return Log
	 */
	public function updateLog(Log $log, stdClass $data)
	{
		Utils::updateProperties($log, $data, [
			'description' => FALSE
		]);

		Utils::checkProperty($data, 'loggedDate', TRUE);
		Utils::checkProperty($data, 'style', TRUE);
		$log->setLoggedDate(Utils::toDateTime($data->loggedDate));

		$id = $data->route->id;
		if (!$route = $this->ropeRepository->getById($id)) {
			if (!$route = $this->boulderRepository->getById($id)) {
				throw MappingException::invalidRelation('route.id', $id);
			}
		}
		$log->setRoute($route);

		Utils::checkProperty($data, 'style', TRUE);
		if ($data->style !== NULL) {
			if (!$style = $this->styleRepository->getById($data->style)) {
				throw MappingException::invalidRelation('style', $data->style);
			}
			$log->setStyle($style);
		}

		$this->logRepository->save($log);
		return $log;
	}

}
