<?php
/**
 * Test: LineRepository test
 */

use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Route;
use GoClimb\Model\Entities\Sector;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\LineRepository;
use GoClimb\Model\Repositories\SectorRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class LineRepositoryTestCase extends DatabaseTestCase
{

	const LINE_NAME = 'Line Test';
	const SECTOR_NAME = 'Sector One';


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
		$sector = $this->sectorRepository->getByName(self::SECTOR_NAME, $wall);
		$line = $this->lineRepository->getByName(self::LINE_NAME, $sector);

		Assert::type(Line::class, $line);
		Assert::equal(1, $line->getId());

		$wall = $this->wallRepository->getById(2);
		$sector = $this->sectorRepository->getByName('Sector Two', $wall);
		$line = $this->lineRepository->getByName(self::LINE_NAME, $sector);

		Assert::null($line);
	}


	public function testMapping()
	{
		$line = $this->lineRepository->getByName(self::LINE_NAME, $this->sectorRepository->getByName(self::SECTOR_NAME, $this->wallRepository->getById(1)));

		Assert::type(Sector::class, $line->getSector());
		Assert::equal(1, $line->getSector()->getId());

		/*Helpers::assertTypeRecursive(Route::class, $line->getRoutes());
		Assert::equal([1], Helpers::mapIds($line->getRoutes()));*/
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		return [
			$wallOne = (new Wall)->setName('Wall One'),
			$sectorOne = (new Sector)->setName(self::SECTOR_NAME)->setWall($wallOne),
			$wallTwo = (new Wall)->setName('Wall Two'),
			$sectorTwo = (new Sector)->setName('Sector Two')->setWall($wallTwo),
			$builder = (new User)->setEmail('aa@aa.aa')->setPassword('aaa'),
			$line = (new Line)->setName(self::LINE_NAME)->setSector($sectorOne),
			/*$route = (new Route)->setName('Test Route')->setBuilder($builder)->setLine($line),
			$line->addRoute($route),*/
		];
	}
}

testCase(LineRepositoryTestCase::class);
