<?php
/**
 * TEST: PrivilegeRepository test
 *
 * @author Martin Mikšik
 */

use OnlineClimbing\Model\Repositories\PrivilegeRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


$container = require __DIR__ . '/../../bootstrap.php';

class PrivilegeRepositoryTestCase extends DatabaseTestCase
{

	public function testGetByName()
	{
		/** @var PrivilegeRepository $privilegeRepository */
		$privilegeRepository = $this->container->getByType(PrivilegeRepository::class);
		Assert::truthy($wall = $privilegeRepository->getByName("edit"));
	}

}

testCase(new PrivilegeRepositoryTestCase($container));
