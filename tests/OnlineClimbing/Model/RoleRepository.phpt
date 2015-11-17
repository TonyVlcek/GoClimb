<?php
/**
 * Test: RoleRepository
 *
 * @author Tomáš Blatný
 */

use Nette\DI\Container;
use OnlineClimbing\Model\Entities\Role;
use OnlineClimbing\Model\Repositories\RoleRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


/** @var Container $container */
$container = require __DIR__ . "/../../bootstrap.php";

class RoleRepositoryTestCase extends DatabaseTestCase
{
	public function testGetById()
	{
		/** @var RoleRepository $roleRepository */
		$roleRepository = $this->container->getByType(RoleRepository::class);
		/** @var WallRepository $wallRepository */
		$wallRepository = $this->container->getByType(WallRepository::class);

		Assert::count(2, $roles = $roleRepository->getByWall($wallRepository->getById(1)));

		Assert::equal([1, 2], array_map(function (Role $role) {
			return $role->getId();
		}, $roles));

		Assert::equal($roles[0], $roles[1]->getParent());
	}
}

testCase(new RoleRepositoryTestCase($container));
