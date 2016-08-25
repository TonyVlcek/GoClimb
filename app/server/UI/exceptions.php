<?php

namespace GoClimb\UI;

use Exception;


class ControlException extends Exception {}


class UserException extends ControlException
{

	const NOT_EXISTING = 1;

	public static function notExisting($id)
	{
		return new self(sprintf('User id: %d does not exist.', $id), self::NOT_EXISTING);
	}

}

class FileException extends ControlException
{

	const NOT_FOUND = 1;

	public static function notFound($fileName)
	{
		return new self(sprintf('File %s not found.', $$fileName), self::NOT_FOUND);
	}

}
