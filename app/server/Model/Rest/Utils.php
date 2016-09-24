<?php

namespace GoClimb\Model\Rest;

use DateTime;
use GoClimb\Model\MappingException;
use stdClass;


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


	public static function updateProperties($entity, stdClass $data, array $fieldsDefinition)
	{
		foreach ($fieldsDefinition as $field => $required) {
			self::checkProperty($data, $field, $required);
			$method = 'set' . ucfirst($field);
			$entity->$method($data->$field);
		}
	}


	/**
	 * @param stdClass $data
	 * @param string $field
	 * @param bool $required
	 */
	public static function checkProperty(stdClass $data, $field, $required = FALSE)
	{
		if ((!property_exists($data, $field)) || ($required && ($data->$field === NULL))) {
			throw MappingException::invalidField($field, $required);
		}
	}

}
