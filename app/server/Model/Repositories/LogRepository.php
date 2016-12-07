<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Log;
use GoClimb\Model\Entities\Wall;
use Nette\Utils\DateTime;


class LogRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Log|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @return Log[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findBy([], ['loggedDate' => 'DESC']);
	}

	public function getLogsByWalls(Wall ...$walls)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb->select('l')
			->from('GoClimb\Model\Entities\Log', 'l')
			->leftJoin('l.style', 's')
			->leftJoin('l.route', 'r')
			->leftJoin('r.difficulty', 'd')
			->addSelect('d.points + s.boulderPoints AS sumPoints')
			->orderBy('sumPoints', 'DESC');


		$criteria['loggedDate > '] = new DateTime('-1 year');

		if (is_null($walls)){
			$criteria['route.line.sector.wall'] = $walls;
		}

		$qb->whereCriteria($criteria);

		dump($qb->getQuery()->getSQL());
		return $qb->getQuery()->getResult();
	}
}
