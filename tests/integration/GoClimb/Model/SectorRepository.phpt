<?php
/**
 * TEST: SectorRepository test
 *
 * @author Tony Vlček
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

	/** @var SectorRepository $sectorRepository */
	private $sectorRepository;

	/** @var WallRepository $wallRepository */
	private $wallRepository;


	public function __construct(SectorRepository $sectorRepository, WallRepository $wallRepository)
	{
		$this->sectorRepository = $sectorRepository;
		$this->wallRepository = $wallRepository;
	}


	public function testGetByName()
	{
		Assert::null($this->sectorRepository->getByName('InvalidNameTest', $this->wallRepository->getById(1)));
		Assert::truthy($sector = $this->sectorRepository->getByName('TestSector', $this->wallRepository->getById(1)));
		Assert::equal(1, $sector->getId());
	}


	public function testGetByWall()
	{
		Helpers::assertTypeRecursive(Sector::class, $sectors = $this->sectorRepository->getByWall($this->wallRepository->getById(1)));
		Assert::equal([1], Helpers::mapIds($sectors));
	}


	public function testMapping()
	{
		$sector = $this->sectorRepository->getByName('TestSector', $this->wallRepository->getById(1));
		Assert::type(Wall::class, $wall = $sector->getWall());
		Assert::equal(1, $wall->getId());
		Helpers::assertTypeRecursive(Line::class, $lines = $sector->getLines());
		Assert::equal([1], Helpers::mapIds($lines));
	}

}

testCase(SectorRepositoryTestCase::class);
