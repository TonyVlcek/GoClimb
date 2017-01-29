<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Log;
use GoClimb\Model\Entities\Rope;
use GoClimb\Model\Rest\Utils;


class LogMapper
{

	/**
	 * @param Log[] $logs
	 * @return array
	 */
	public static function mapArray(array $logs)
	{
		$result = [];
		foreach ($logs as $log) {
			$result[$log->getId()] = self::map($log);
		}
		return $result;
	}


	/**
	 * @param Log $log
	 * @return array
	 */
	public static function map(Log $log)
	{
		$route = ($log->getRoute() instanceof Rope) ? RopeMapper::map($log->getRoute()) : BoulderMapper::map($log->getRoute());
		return [
			'id' => $log->getId(),
			'user' => UserMapper::mapBasicInfo($log->getUser()),
			'style' => StyleMapper::map($log->getStyle()),
			'route' => $route,
			'loggedDate' => Utils::formatDateTime($log->getLoggedDate()),
			'description' => $log->getDescription(),
			'tries' => $log->getTries(),
			'points' => $log->getPoints(),
			'wall' => WallMapper::mapBasicInfo($log->getRoute()->getLine()->getSector()->getWall())
		];
	}

}
