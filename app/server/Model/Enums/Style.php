<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Enums;

class Style
{

	const OS = 'os';
	const FLASH = 'flash';
	const PP2 = 'pp2';
	const PPN = 'ppn';
	const SOLO = 'solo';
	const AF = 'af';


	/**
	 * @return string[]
	 */
	public static function getAll()
	{
		return [
			self::OS,
			self::FLASH,
			self::PP2,
			self::PPN,
			self::SOLO,
			self::AF,
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
