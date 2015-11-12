<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Repositories;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use OnlineClimbing\Model\MappingException;


abstract class BaseRepository
{

	/** @var string */
	protected $entityNamespace = '\\OnlineClimbing\\Model\\Entities\\';

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
			return $this->entityNamespace . strtolower($matches[1]);
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
