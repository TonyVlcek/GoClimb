<?php

namespace GoClimb\Model\Rest;

use DateTime;


class Utils
{


	/**
	 * @param DateTime|NULL $date
	 * @return string|NULL
	 */
	public static function formatDateTime(DateTime $date = NULL)
	{
		return $date ? $date->format(DateTime::ISO8601) : NULL;
	}
}
