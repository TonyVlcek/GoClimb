<?php
/**
 * Test: SectorRepository test
 */

use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Sector;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\SectorRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class SectorRepositoryTestCase extends DatabaseTestCase
{

	const SECTOR_NAME = 'Sector';


	/** @var SectorRepository $sectorRepository */
	private $sectorRepository;

	/** @var WallRepository $wallRepository */
	private $wallRepository;


	public function __construct(SectorRepository $sectorRepository, WallRepository $wallRepository)
	{
		parent::__construct();
		$this->sectorRepository = $sectorRepository;
		$this->wallRepository = $wallRepository;
	}


	public function testGetByName()
	{
		Assert::null($this->sectorRepository->getByName('InvalidNameTest', $this->wallRepository->getById(1)));
		Assert::truthy($sector = $this->sectorRepository->getByName(self::SECTOR_NAME, $this->wallRepository->getById(1)));
		Assert::equal(1, $sector->getId());
	}


	public function testGetByWall()
	{
		Helpers::assertTypeRecursive(Sector::class, $sectors = $this->sectorRepository->getByWall($this->wallRepository->getById(1)));
		Assert::equal([1], Helpers::mapIds($sectors));
	}


	public function testMapping()
	{
		$sector = $this->sectorRepository->getByName(self::SECTOR_NAME, $this->wallRepository->getById(1));
		Assert::type(Wall::class, $wall = $sector->getWall());
		Assert::equal(1, $wall->getId());
		Helpers::assertTypeRecursive(Line::class, $lines = $sector->getLines());
		Assert::equal([1], Helpers::mapIds($lines));
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		return [
			$wall = (new Wall)->setName('Wall'),
			$sector = (new Sector)->setName(self::SECTOR_NAME)->setWall($wall),
			$line = (new Line)->setName('Line One')->setSector($sector),
			$sector->addLine($line),
		];
	}
}

testCase(SectorRepositoryTestCase::class);
