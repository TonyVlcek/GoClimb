<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\EntityException;


abstract class ReadonlyRepository extends BaseRepository
{

	/**
	 * @throws EntityException
	 */
	public function save($entity, $flush = TRUE)
	{
		throw EntityException::readonlyEntity(get_class($entity));
	}

}
