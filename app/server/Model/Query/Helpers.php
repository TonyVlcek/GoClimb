<?php

namespace GoClimb\Model\Query;

class Helpers
{

	/**
	 * @param string $string
	 * @return string
	 */
	public static function escapeWildcard($string)
	{
		return addcslashes($string, "%_\\");
	}

}
