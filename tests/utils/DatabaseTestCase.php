<?php

namespace GoClimb\Tests\Utils;

use Kdyby\Doctrine\Connection;
use Kdyby\Doctrine\EntityManager;


abstract class DatabaseTestCase extends TestCase
{

	/** @var EntityManager */
	protected $entityManager;

	/** @var Connection */
	protected $connection;


	public function injectConnection(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->connection = $entityManager->getConnection();
	}


	public function __construct()
	{
		Locker::lock(Locker::DATABASE);
	}


	protected function setUp()
	{
		$this->connection->prepare('SET foreign_key_checks = 0')->execute();
		$statement = $this->connection->prepare('SHOW TABLES');
		$statement->execute();
		while ($table = $statement->fetchColumn(0)) {
			$this->connection->prepare('TRUNCATE TABLE ' . $table)->execute();
		}
		foreach ($this->getFixtures() as $fixture) {
			$this->entityManager->persist($fixture);
		}
		$this->entityManager->flush();
	}


	/**
	 * @return array
	 */
	abstract protected function getFixtures();

}
