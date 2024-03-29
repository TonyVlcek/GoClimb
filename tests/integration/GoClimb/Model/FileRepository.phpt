<?php
/**
 * Test: FileRepository test
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
		parent::__construct();
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


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		return [
			$wall = (new Wall)->setName('Wall'),
			(new File)->setWall($wall)->setName('Name')->setPath('Path'),
		];
	}
}

testCase(FileRepositoryTestCase::class);
