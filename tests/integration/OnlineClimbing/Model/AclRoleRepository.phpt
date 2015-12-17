<?php
/**
 * Test: AclRoleRepository
 *
 * @author Tomáš Blatný
 */

use OnlineClimbing\Model\Entities\AclRole;
use OnlineClimbing\Model\Repositories\AclRoleRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Helpers;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class AclRoleRepositoryTestCase extends DatabaseTestCase
{

	/** @var AclRoleRepository */
	private $aclRoleRepository;

	/** @var WallRepository */
	private $wallRepository;


	public function __construct(AclRoleRepository $roleRepository, WallRepository $wallRepository)
	{
		parent::__construct();
		$this->aclRoleRepository = $roleRepository;
		$this->wallRepository = $wallRepository;
	}


	public function testGetByName()
	{
		$wall = $this->wallRepository->getById(1);
		$role = $this->aclRoleRepository->getByName('Role 1', $wall);
		Assert::type(AclRole::class, $role);
		Assert::equal(1, $role->getId());
	}


	public function testGetByWall()
	{
		$wall = $this->wallRepository->getById(1);
		Assert::count(2, $roles = $this->aclRoleRepository->getByWall($wall));

		Assert::equal([1, 2], Helpers::mapIds($roles));
	}


	public function testMapping()
	{
		$wall = $this->wallRepository->getById(1);
		$roles = $this->aclRoleRepository->getByWall($wall);

		$parent = $roles[0];
		$child = $roles[1];

		Helpers::assertTypesRecursive(AclRole::class, $parent->getChildren());
		Helpers::assertTypesRecursive(AclRole::class, $child->getChildren());

		Assert::equal($parent, $child->getParent());
		Assert::null($parent->getParent());

		Assert::equal([2], Helpers::mapIds($parent->getChildren()));
		Assert::equal([], Helpers::mapIds($child->getChildren()));
	}

}

testCase(AclRoleRepositoryTestCase::class);