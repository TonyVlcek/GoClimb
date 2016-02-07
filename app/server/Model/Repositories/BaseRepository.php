<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Kdyby\Doctrine\QueryBuilder;
use GoClimb\Model\EntityException;
use GoClimb\Model\MappingException;
use GoClimb\Model\Query\IFilter;


abstract class BaseRepository
{

	/** @var string */
	protected $entityNamespace = '\\GoClimb\\Model\\Entities\\';

	/** @var EntityManager */
	private $entityManager;


	/**
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	/**
	 * @param IFilter[] ...$filters
	 * @return QueryBuilder
	 */
	public function getBuilderByFilters(IFilter ...$filters)
	{
		$queryBuilder = $this->getDoctrineRepository()->createQueryBuilder($entityAlias = 'e');
		foreach ($filters as $filter) {
			$part = $filter->applyFilter($queryBuilder, $entityAlias);
			if ($part) {
				$queryBuilder->andWhere($part);
			}
		}
		return $queryBuilder;
	}


	/**
	 * @param object $entity
	 * @param bool $flush
	 * @return $this
	 * @throws EntityException
	 */
	public function save($entity, $flush = TRUE)
	{
		if (!$this->isOwnEntity($entity)) {
			throw EntityException::notOwnEntity(get_class($entity));
		}

		$em = $this->getEntityManager()
			->persist($entity);
		if ($flush) {
			$em->flush();
		}

		return $this;
	}


	public function getResultByFilters(IFilter ...$filters)
	{
		return $this->getBuilderByFilters(...$filters)->getQuery()->execute();
	}


	/**
	 * @param object $entity
	 * @return bool
	 */
	protected function isOwnEntity($entity)
	{
		$entityClass = $this->getEntityClass();
		return $entity instanceof $entityClass;
	}


	/**
	 * @return EntityManager
	 */
	protected function getEntityManager()
	{
		return $this->entityManager;
	}


	/**
	 * @return string
	 * @throws MappingException
	 */
	protected function getEntityClass()
	{
		$matches = [];
		$class = get_called_class();
		if (preg_match('#([a-z0-9]+)repository$#i', $class, $matches)) {
			return $this->entityNamespace . $matches[1];
		}
		throw MappingException::cannotDetermineRepositoryName($class);
	}


	/**
	 * @return EntityRepository
	 */
	protected function getDoctrineRepository()
	{
		return $this->entityManager->getRepository($this->getEntityClass());
	}

}
