<?php
/**
 * Test: RoleRepository
 *
 * @author Tomáš Blatný
 */

use OnlineClimbing\Model\Entities\Role;
use OnlineClimbing\Model\Repositories\RoleRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Helpers;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class RoleRepositoryTestCase extends DatabaseTestCase
{

	/** @var RoleRepository */
	private $roleRepository;

	/** @var WallRepository */
	private $wallRepository;


	public function __construct(RoleRepository $roleRepository, WallRepository $wallRepository)
	{
		parent::__construct();
		$this->roleRepository = $roleRepository;
		$this->wallRepository = $wallRepository;
	}


	public function testGetByName()
	{
		$wall = $this->wallRepository->getById(1);
		$role = $this->roleRepository->getByName('Role 1', $wall);
		Assert::type(Role::class, $role);
		Assert::equal(1, $role->getId());
	}


	public function testGetByWall()
	{
		$wall = $this->wallRepository->getById(1);
		Assert::count(2, $roles = $this->roleRepository->getByWall($wall));

		Assert::equal([1, 2], Helpers::mapIds($roles));
	}


	public function testMapping()
	{
		$wall = $this->wallRepository->getById(1);
		$roles = $this->roleRepository->getByWall($wall);

		$parent = $roles[0];
		$child = $roles[1];

		Helpers::assertTypesRecursive(Role::class, $parent->getChildren());
		Helpers::assertTypesRecursive(Role::class, $child->getChildren());

		Assert::equal($parent, $child->getParent());
		Assert::null($parent->getParent());

		Assert::equal([2], Helpers::mapIds($parent->getChildren()));
		Assert::equal([], Helpers::mapIds($child->getChildren()));
	}

}

testCase(RoleRepositoryTestCase::class);
