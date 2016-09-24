<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Enums;

class Parameter
{

	const SIDE_FACE = 'sideFace';
	const STRENGTH = 'strength';
	const TECHNIQUE = 'technique';
	const ENDURANCE = 'endurance';
	const BOULDER = 'boulder';
	const KNOW_HOW = 'knowHow';
	const KEY_POINTS = 'keyPoints';
	const BULGE = 'bulge';
	const SMALL_HANDLES = 'smallHandles';


	/**
	 * @return string[]
	 */
	public static function getAll()
	{
		return [
			self::SIDE_FACE,
			self::STRENGTH,
			self::TECHNIQUE,
			self::ENDURANCE,
			self::BOULDER,
			self::KNOW_HOW,
			self::KEY_POINTS,
			self::BULGE,
			self::SMALL_HANDLES,
		];
	}


	/**
	 * @param string $parameter
	 * @return bool
	 */
	public static function isValid($parameter)
	{
		return in_array($parameter, self::getAll(), TRUE);
	}

}
