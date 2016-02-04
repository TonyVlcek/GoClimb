<?php
/**
 * TEST: FileRepository test
 *
 * @author Martin Mikšík
 */

use GoClimb\Model\Entities\File;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\FileRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class FileRepositoryTestCase extends DatabaseTestCase
{

	/** @var FileRepository $fileRepository */
	private $fileRepository;


	public function __construct(FileRepository $fileRepository)
	{
		$this->fileRepository = $fileRepository;
	}


	public function testGetById()
	{
		Assert::null($this->fileRepository->getById(0));
		Assert::type(File::class, $file = $this->fileRepository->getById(1));
		Assert::equal(1, $file->getId());
	}


	public function testMapping()
	{
		$file = $this->fileRepository->getById(1);
		Assert::type(Wall::class, $wall = $file->getWall());
		Assert::equal(1, $wall->getId());
	}

}

testCase(FileRepositoryTestCase::class);
