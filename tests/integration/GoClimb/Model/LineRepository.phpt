<?php
/**
 * TEST: LineRepository test
 *
 * @author Martin Mikšík
 */

use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Route;
use GoClimb\Model\Entities\Sector;
use GoClimb\Model\Repositories\LineRepository;
use GoClimb\Model\Repositories\SectorRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class LineRepositoryTestCase extends DatabaseTestCase
{

	/** @var LineRepository $lineRepository */
	private $lineRepository;

	/** @var SectorRepository $sectorRepository */
	private $sectorRepository;

	/** @var WallRepository $wallRepository */
	private $wallRepository;


	public function __construct(LineRepository $lineRepository, SectorRepository $sectorRepository, WallRepository $wallRepository)
	{
		$this->lineRepository = $lineRepository;
		$this->sectorRepository = $sectorRepository;
		$this->wallRepository = $wallRepository;
	}


	public function testGetByName()
	{
		$wall = $this->wallRepository->getById(1);
		$sector = $this->sectorRepository->getByName('TestSector', $wall);
		$line = $this->lineRepository->getByName('LineTest', $sector);

		Assert::type(Line::class, $line);
		Assert::equal(1, $line->getId());

		$wall = $this->wallRepository->getById(2);
		$sector = $this->sectorRepository->getByName('Test Sector in Another Wall', $wall);
		$line = $this->lineRepository->getByName('LineTest', $sector);

		Assert::null($line);
	}


	public function testMapping()
	{
		$line = $this->lineRepository->getByName('LineTest', $this->sectorRepository->getByName('TestSector', $this->wallRepository->getById(1)));

		Assert::type(Sector::class, $line->getSector());
		Assert::equal(1, $line->getSector()->getId());

		Helpers::assertTypeRecursive(Route::class, $line->getRoutes());
		Assert::equal([1], Helpers::mapIds($line->getRoutes()));
	}

}

testCase(LineRepositoryTestCase::class);
