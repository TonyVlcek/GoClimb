<?php
/**
 * TEST: LineRepository test
 *
 * @author Martin Mikšík
 */

use Nette\DI\Container;
use OnlineClimbing\Model\Repositories\LineRepository;
use OnlineClimbing\Model\Repositories\SectorRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;
use OnlineClimbing\Model\Repositories\WallRepository;


$container = $container = require __DIR__ . '/../../bootstrap.php';

class LineRepositoryTestCase extends DatabaseTestCase
{

	/** @var LineRepository $lineRepository */
	private $lineRepository;

	/** @var SectorRepository $sectorRepository */
	private $sectorRepository;


	/** @var WallRepository $wallRepository */
	private $wallRepository;


	public function __construct(Container $container)
	{
		parent::__construct($container);
		$this->sectorRepository = $this->container->getByType(SectorRepository::class);
		$this->lineRepository = $this->container->getByType(lineRepository::class);
		$this->wallRepository = $this->container->getByType(WallRepository::class);
	}


	public function testGetByName()
	{
		$wall = $this->wallRepository->getById(1);
		$sector = $this->sectorRepository->getByName("TestSector", $wall);
		$line = $this->lineRepository->getByName('LineTest', $sector);

		Assert::truthy($line);
		Assert::equal(1, $line->getId());

		$wall = $this->wallRepository->getById(2);
		$sector = $this->sectorRepository->getByName("Test Sector in Another Wall", $wall);
		$line = $this->lineRepository->getByName('LineTest', $sector);

		Assert::null($line);
	}

}

testCase(new LineRepositoryTestCase($container));
