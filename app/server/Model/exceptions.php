<?php

namespace GoClimb\Model;

use Exception;
use GoClimb\InvalidArgumentException;


class MappingException extends InvalidArgumentException
{

	public static function cannotDetermineRepositoryName($repositoryClass)
	{
		return new self(sprintf('Cannot determine repository name from class name %s.', $repositoryClass));
	}


	public static function invalidField($filed, $required = FALSE)
	{
		if ($required) {
			return new self(sprintf('Field \'%s\' is required and cannot be empty or null.', $filed));
		}

		return new self(sprintf('Field \'%s\' is missing.', $filed));
	}


	public static function invalidTranslation($shortcut)
	{
		return new self(sprintf('Language with \'%s\' shortcut is not available for this wall.', $shortcut));
	}


	public static function invalidData()
	{
		return new self('No data or invalid data received.');
	}

}


class ModelException extends Exception {}


class CompanyException extends ModelException
{

	const DUPLICATE_NAME = 1;


	public static function duplicateName($name)
	{
		return new self(sprintf('Company with name \'%s\' already exists.', $name), self::DUPLICATE_NAME);
	}

}


class EntityException extends ModelException
{

	const NOT_OWN_ENTITY = 1;


	public static function notOwnEntity($class)
	{
		return new self(sprintf('Entity \'%s\' does not belong to this repository.', $class), self::NOT_OWN_ENTITY);
	}

}


class UserException extends ModelException
{

	const DUPLICATE_NAME = 1;
	const DUPLICATE_EMAIL = 2;


	public static function duplicateName($name)
	{
		return new self(sprintf('User with name \'%s\' already exists.', $name), self::DUPLICATE_NAME);
	}


	public static function duplicateEmail($email)
	{
		return new self(sprintf('User with email \'%s\' already exists.', $email), self::DUPLICATE_EMAIL);
	}

}


class WallException extends ModelException
{

	const DUPLICATE_NAME = 1;
	const DUPLICATE_BASE_URL = 2;


	public static function duplicateName($name)
	{
		return new self(sprintf('Wall with name \'%s\' already exists.', $name), self::DUPLICATE_NAME);
	}

}


class WallLanguageException extends ModelException
{

	public static function oneTimeSetter($property)
	{
		return new self(sprintf('Property \'%s\' can be set just once.', $property));
	}


	public static function invalidUrl($url)
	{
		return new self(sprintf('\'%s\' in not a valid URL.', $url));
	}

}
