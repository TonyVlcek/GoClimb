<?php
/**
 * Test: AclRoleRepository
 *
 * @author Tomáš Blatný
 */

use GoClimb\Model\Entities\AclRole;
use GoClimb\Model\Repositories\AclRoleRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
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
		$this->aclRoleRepository = $roleRepository;
		$this->wallRepository = $wallRepository;
	}


	public function testGetByName()
	{
		$invalidWall = $this->wallRepository->getById(3);
		$wall = $this->wallRepository->getById(1);

		Assert::null($this->aclRoleRepository->getByName("Role 1", $invalidWall));
		Assert::null($this->aclRoleRepository->getByName("InvalidAclTest", $wall));


		$role = $this->aclRoleRepository->getByName('Role 1', $wall);
		Assert::type(AclRole::class, $role);
		Assert::equal(1, $role->getId());
	}


	public function testGetByWall()
	{
		$wall = $this->wallRepository->getById(1);
		Helpers::assertTypeRecursive(AclRole::class, $roles = $this->aclRoleRepository->getByWall($wall));
		Assert::equal([1, 2], Helpers::mapIds($roles));
	}


	public function testMapping()
	{
		$wall = $this->wallRepository->getById(1);
		$roles = $this->aclRoleRepository->getByWall($wall);

		$parent = $roles[0];
		$child = $roles[1];

		Helpers::assertTypeRecursive(AclRole::class, $parent->getChildren());
		Helpers::assertTypeRecursive(AclRole::class, $child->getChildren());

		Assert::equal($parent, $child->getParent());
		Assert::null($parent->getParent());

		Assert::equal([2], Helpers::mapIds($parent->getChildren()));
		Assert::equal([], Helpers::mapIds($child->getChildren()));
	}

}

testCase(AclRoleRepositoryTestCase::class);
