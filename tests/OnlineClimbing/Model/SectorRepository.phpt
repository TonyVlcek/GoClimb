<?php
/**
 * TEST: SectorRepository test
 *
 * @author Tony Vlček
 */

use OnlineClimbing\Model\Repositories\SectorRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


$container = $container = require __DIR__ . '/../../bootstrap.php';

class SectorRepositoryTestCase extends DatabaseTestCase
{

	public function testGetByName()
	{
		/** @var SectorRepository $sectorRepository */
		$sectorRepository = $this->container->getByType(SectorRepository::class);

		/** @var WallRepository $wallRepository */
		$wallRepository = $this->container->getByType(WallRepository::class);

		Assert::truthy($sector = $sectorRepository->getByName($wallRepository->getById(1), "TestSector"));
		Assert::equal(1, $sector->getId());
		Assert::equal(1, $sector->getWall()->getId());
	}
}

testCase(new SectorRepositoryTestCase($container));
