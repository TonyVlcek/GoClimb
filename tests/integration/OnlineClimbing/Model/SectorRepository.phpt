<?php
/**
 * TEST: SectorRepository test
 *
 * @author Tony Vlček
 */

use OnlineClimbing\Model\Entities\Line;
use OnlineClimbing\Model\Entities\Sector;
use OnlineClimbing\Model\Entities\Wall;
use OnlineClimbing\Model\Repositories\SectorRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Helpers;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
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
		parent::__construct();
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
		Helpers::assertTypesRecursive(Sector::class, $sectors = $this->sectorRepository->getByWall($this->wallRepository->getById(1)));
		Assert::equal([1], Helpers::mapIds($sectors));
	}


	public function testMapping()
	{
		$sector = $this->sectorRepository->getByName('TestSector', $this->wallRepository->getById(1));
		Assert::type(Wall::class, $wall = $sector->getWall());
		Assert::equal(1, $wall->getId());
		Helpers::assertTypesRecursive(Line::class, $lines = $sector->getLines());
		Assert::equal([1], Helpers::mapIds($lines));
	}

}

testCase(SectorRepositoryTestCase::class);
