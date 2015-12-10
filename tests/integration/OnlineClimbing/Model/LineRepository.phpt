<?php
/**
 * TEST: LineRepository test
 *
 * @author Martin Mikšík
 */

use OnlineClimbing\Model\Entities\Line;
use OnlineClimbing\Model\Entities\Route;
use OnlineClimbing\Model\Entities\Sector;
use OnlineClimbing\Model\Repositories\LineRepository;
use OnlineClimbing\Model\Repositories\SectorRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Helpers;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
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
		parent::__construct();
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

		Helpers::assertTypesRecursive(Route::class, $line->getRoutes());
		Assert::equal([1], Helpers::mapIds($line->getRoutes()));
	}

}

testCase(LineRepositoryTestCase::class);
