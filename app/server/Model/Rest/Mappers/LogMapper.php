<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Log;
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
		return [
			'id' => $log->getId(),
			'user' => UserMapper::mapBasicInfo($log->getUser()),
			'style' => StyleMapper::map($log->getStyle()),
			'route' => RouteMapper::map($log->getRoute()),
			'loggedDate' => Utils::formatDateTime($log->getLoggedDate()),
			'description' => $log->getDescription(),
			'points' => $log->getPoints(),
		];
	}

}
