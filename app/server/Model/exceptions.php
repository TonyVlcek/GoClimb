<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model;

use Exception;
use GoClimb\InvalidArgumentException;


class MappingException extends InvalidArgumentException
{

	public static function cannotDetermineRepositoryName($repositoryClass)
	{
		return new self(sprintf('Cannot determine repository name from class name %s.', $repositoryClass));
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
	const INVALID_URL = 3;


	public static function duplicateName($name)
	{
		return new self(sprintf('Wall with name \'%s\' already exists.', $name), self::DUPLICATE_NAME);
	}


	public static function invalidUrl($url)
	{
		return new self(sprintf('\'%s\' in not a valid URL.', $url), self::INVALID_URL);
	}

}

class WallLanguageException extends ModelException
{

	const DUPLICATE_URL = 2;


	public static function duplicateUrl($url)
	{
		return new self(sprintf('Wall with base url \'%s\' already exists.', $url), self::DUPLICATE_URL);
	}

}
