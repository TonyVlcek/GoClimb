<?php

/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Tests\Utils;

use Kdyby\Doctrine\Connection;
use Kdyby\Doctrine\EntityManager;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;


class DatabaseTestCase extends TestCase
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
		$this->importData();
	}


	protected function tearDown()
	{
		//
	}


	private function importData()
	{
		$this->connection->prepare('SET foreign_key_checks = 0')->execute();
		$statement = $this->connection->prepare('SHOW TABLES');
		$statement->execute();
		while ($table = $statement->fetchColumn(0)) {
			$this->connection->prepare('TRUNCATE TABLE ' . $table)->execute();
		}
		$blackList = ['.', '..'];
		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(DATA_DIR)) as $fileInfo) {
			if (!in_array($fileInfo->getFileName(), $blackList, TRUE)) {
				$this->importTable($fileInfo->getBaseName('.csv'), $fileInfo->getRealPath());
			}
		}
	}


	private function importTable($table, $file)
	{
		$sql = 'LOAD DATA INFILE "%s" INTO TABLE %s ' .
			'COLUMNS TERMINATED BY \',\' ' .
			'OPTIONALLY ENCLOSED BY \'"\' ' .
			'ESCAPED BY \'"\' ' .
			'LINES TERMINATED BY \'' . $this->getLineSeparator() . '\' ' .
			'IGNORE 1 LINES';
		$this->connection->prepare(sprintf($sql, $this->fixFilePath($file), $table))->execute();
	}


	private function fixFilePath($path)
	{
		if (DIRECTORY_SEPARATOR === '\\') {
			return str_replace('\\', '\\\\', $path);
		}
		return $path;
	}


	private function getLineSeparator()
	{
		return DIRECTORY_SEPARATOR === '\\' ? '\r\n' : '\n';
	}

}
