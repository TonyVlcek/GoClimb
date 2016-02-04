<?php

/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Tests\Utils;

use Doctrine\DBAL\Migrations\Migration;
use Kdyby\Doctrine\Connection;
use Kdyby\Doctrine\EntityManager;
use Nette\DI\Container;
use Zenify\DoctrineMigrations\Configuration\Configuration;


class DatabaseTestCase extends TestCase
{

	/** @var EntityManager */
	protected $entityManager;

	/** @var Connection */
	protected $connection;

	/** @var string */
	private $dbname;

	/** @var Configuration */
	private $migrationsConfiguration;

	/** @var Container */
	private $container;


	public function injectConnection(EntityManager $entityManager, Configuration $migrationsConfiguration, Container $container)
	{
		$this->entityManager = $entityManager;
		$this->connection = $entityManager->getConnection();
		$this->migrationsConfiguration = $migrationsConfiguration;
		$this->container = $container;
	}


	protected function setUp()
	{
		$this->prepareDatabase();
	}


	protected function tearDown()
	{
		$this->connection->query('DROP DATABASE IF EXISTS ' . $this->dbname);
	}


	protected function getFixtures()
	{
		return [];
	}


	private function prepareDatabase()
	{
		$this->dbname = 'goclimb_tests_' . getmypid();
		$this->connection->query('DROP DATABASE IF EXISTS ' . $this->dbname);
		$this->connection->query('CREATE DATABASE ' . $this->dbname);
		$this->connection->close();
		$this->connection->__construct(
			['dbname' => $this->dbname] + $this->connection->getParams(),
			$this->connection->getDriver(),
			$this->connection->getConfiguration(),
			$this->connection->getEventManager()
		);
		$this->connection->connect();
		$this->runMigrations();
		foreach ($this->getFixtures() as $fixture) {
			$this->entityManager->persist($fixture);
			$this->entityManager->flush();
		}
	}


	private function runMigrations()
	{
		$this->migrationsConfiguration->__construct($this->container, $this->connection);
		$this->migrationsConfiguration->registerMigrationsFromDirectory(__DIR__ . '/../../migrations');
		(new Migration($this->migrationsConfiguration))->migrate($this->migrationsConfiguration->getLatestVersion());
	}

}
