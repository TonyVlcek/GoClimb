<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Console;

use Doctrine\DBAL\Migrations\OutputWriter;


class NullOutputWriter extends OutputWriter
{

	public function write($message)
	{
		// do nothing
	}

}
