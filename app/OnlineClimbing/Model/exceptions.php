<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model;

use Exception;
use OnlineClimbing\InvalidArgumentException;


class MappingException extends InvalidArgumentException
{

	public static function cannotDetermineRepositoryName($repositoryClass)
	{
		return new self(sprintf('Cannot determine repository name from class name %s.', $repositoryClass));
	}
}

class ModelException extends Exception {}

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


	public static function duplicateName($name)
	{
		return new self(sprintf('Wall with name \'%s\' already exists.', $name), self::DUPLICATE_NAME);
	}

}
