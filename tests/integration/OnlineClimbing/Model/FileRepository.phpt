<?php
/**
 * TEST: FileRepository test
 *
 * @author Martin Mikšík
 */

use OnlineClimbing\Model\Entities\Wall;
use OnlineClimbing\Model\Repositories\FileRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class FileRepositoryTestCase extends DatabaseTestCase
{

	/** @var FileRepository $fileRepository */
	private $fileRepository;


	public function __construct(FileRepository $fileRepository)
	{
		parent::__construct();
		$this->fileRepository = $fileRepository;
	}


	public function testMapping()
	{
		$file = $this->fileRepository->getById(1);
		Assert::type(Wall::class, $wall = $file->getWall());
		Assert::equal(1, $wall->getId());
	}

}

testCase(FileRepositoryTestCase::class);
