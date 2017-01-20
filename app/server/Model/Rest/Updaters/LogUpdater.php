<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\Log;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Enums\Style;
use GoClimb\Model\LogException;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\BoulderRepository;
use GoClimb\Model\Repositories\LogRepository;
use GoClimb\Model\Repositories\RopeRepository;
use GoClimb\Model\Repositories\StyleRepository;
use GoClimb\Model\Rest\Utils;
use stdClass;


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
	 * @param User $user
	 * @param stdClass $data
	 * @return Log
	 * @throws
	 */
	public function updateLog(Log $log, User $user, stdClass $data)
	{
		Utils::updateProperties($log, $data, [
			'description' => FALSE,
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

		$specialStyles = [Style::OS, Style::FLASH];

		Utils::checkProperty($data, 'style', TRUE);
		if ($data->style !== NULL) {
			if (!$style = $this->styleRepository->getById($data->style)) {
				throw MappingException::invalidRelation('style', $data->style);
			}

			$logDb = $this->logRepository->getByUserAndRoute($user, $route);
			if ($logDb && in_array($log->getStyle(), $specialStyles) && ($style->getId() === NULL || $style->getId() !== $logDb)) {
				throw LogException::duplicateLogForStyle($logDb->getId(), $style->getName());
			}

			$log->setStyle($style);
		}

		Utils::checkProperty($data, 'tries', TRUE);
		if (in_array($log->getStyle(), $specialStyles)) {
			$log->setTries(1);
		} else {
			$log->setTries($data->tries);
		}

		$this->logRepository->save($log);
		return $log;
	}

}
