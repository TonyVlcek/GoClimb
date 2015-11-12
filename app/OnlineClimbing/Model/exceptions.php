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


	public static function duplicateName($name)
	{
		return new self(sprintf('User with name \'%s\' already exists.', $name), self::DUPLICATE_NAME);
	}
}
