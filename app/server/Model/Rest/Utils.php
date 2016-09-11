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
		//Use RFC3339 instead of ISO8601, because of poor support of ISO8601 in safari, and firefox
		//See here http://stackoverflow.com/a/16620332/5862262
		return $date ? $date->format(DateTime::RFC3339) : NULL;
	}


	/**
	 * @param String $date
	 * @return DateTime
	 */
	public static function toDateTime($date)
	{
		return new DateTime($date);
	}
}
