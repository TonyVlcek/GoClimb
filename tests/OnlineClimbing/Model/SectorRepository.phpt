<?php
/**
 * TEST: SectorRepository test
 *
 * @author Tony Vlček
 */

use Nette\DI\Container;
use OnlineClimbing\Model\Repositories\SectorRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


$container = $container = require __DIR__ . '/../../bootstrap.php';

class SectorRepositoryTestCase extends DatabaseTestCase
{

	/** @var SectorRepository $sectorRepository */
	private $sectorRepository;

	/** @var WallRepository $wallRepository */
	private $wallRepository;


	public function __construct(Container $container)
	{
		parent::__construct($container);
		$this->sectorRepository = $this->container->getByType(SectorRepository::class);
		$this->wallRepository = $this->container->getByType(WallRepository::class);
	}


	public function testGetByName()
	{
		Assert::truthy($sector = $this->sectorRepository->getByName('TestSector', $this->wallRepository->getById(1)));
		Assert::equal(1, $sector->getId());
		Assert::equal(1, $sector->getWall()->getId());
	}


	public function testGetByWall()
	{
		Assert::type('array', $sectors = $this->sectorRepository->getByWall($this->wallRepository->getById(1)));
		Assert::equal(1, reset($sectors)->getId());
	}

}

testCase(new SectorRepositoryTestCase($container));
