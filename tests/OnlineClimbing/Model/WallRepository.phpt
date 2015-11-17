<?php
/**
 * TEST: WallRepository test
 *
 * @author Tony Vlček
 */

use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


$container = require __DIR__ . '/../../bootstrap.php';

class WallRepositoryTestCase extends DatabaseTestCase
{

	public function testGetById()
	{
		/** @var WallRepository $wallRepository */
		$wallRepository = $this->container->getByType(WallRepository::class);
		Assert::truthy($wall = $wallRepository->getById(1));
		Assert::equal(1, $wall->getId());
		Assert::equal(1, $wall->getUser()->getId());
	}

}

testCase(new WallRepositoryTestCase($container));
