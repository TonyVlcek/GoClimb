<?php
/**
 * Test: AclRoleRepository
 */

use GoClimb\Model\Entities\AclRole;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\AclRoleRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class AclRoleRepositoryTestCase extends DatabaseTestCase
{

	const WALL_NAME = AclRoleRepository::class . 'Wall One';
	const WALL_TWO_NAME = AclRoleRepository::class . 'Wall Two';
	const PARENT_ROLE_NAME = AclRoleRepository::class . 'Parent Role';
	const CHILD_ROLE_NAME = AclRoleRepository::class . 'Child Role';


	/** @var AclRoleRepository */
	private $aclRoleRepository;

	/** @var WallRepository */
	private $wallRepository;

	/** @var Wall */
	private $wall;

	/** @var AclRole */
	private $parentRole;

	/** @var AclRole */
	private $childRole;


	public function __construct(AclRoleRepository $roleRepository, WallRepository $wallRepository)
	{
		parent::__construct();
		$this->aclRoleRepository = $roleRepository;
		$this->wallRepository = $wallRepository;
	}


	public function setUp()
	{
		parent::setUp();
		$this->wall = $this->wallRepository->getByName(self::WALL_NAME);
		$this->parentRole = $this->aclRoleRepository->getByName(self::PARENT_ROLE_NAME, $this->wall);
		$this->childRole = $this->aclRoleRepository->getByName(self::CHILD_ROLE_NAME, $this->wall);
	}

	public function testGetByName()
	{
		$wallWithoutRoles = $this->wallRepository->getByName(self::WALL_TWO_NAME);

		Assert::null($this->aclRoleRepository->getByName(AclRoleRepository::class, $wallWithoutRoles));
		Assert::null($this->aclRoleRepository->getByName(AclRoleRepository::class . 'InvalidAclTest', $this->wall));

		$role = $this->aclRoleRepository->getByName(self::PARENT_ROLE_NAME, $this->wall);
		Assert::type(AclRole::class, $role);
		Assert::equal(self::PARENT_ROLE_NAME, $role->getName());
	}


	public function testGetByWall()
	{
		Helpers::assertTypeRecursive(AclRole::class, $roles = $this->aclRoleRepository->getByWall($this->wall));
		Assert::contains($this->parentRole, $roles);
		Assert::contains($this->childRole, $roles);
	}


	public function testMapping()
	{
		Helpers::assertTypeRecursive(AclRole::class, $this->parentRole->getChildren());
		Helpers::assertTypeRecursive(AclRole::class, $this->childRole->getChildren());

		Assert::equal($this->parentRole, $this->childRole->getParent());
		Assert::null($this->parentRole->getParent());

		Assert::same([$this->childRole], $this->parentRole->getChildren());
		Assert::equal([], $this->childRole->getChildren());
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		$fixtures = [];
		$fixtures[] = $wall = (new Wall)->setName(self::WALL_NAME);
		$fixtures[] = (new Wall)->setName(self::WALL_TWO_NAME);
		$fixtures[] = $parentRole = (new AclRole)->setName(self::PARENT_ROLE_NAME)->setWall($wall);
		$fixtures[] = $childRole = (new AclRole)->setName(self::CHILD_ROLE_NAME)->setWall($wall)->setParent($parentRole);
		$wall->addRole($parentRole)->addRole($childRole);
		$parentRole->addChild($childRole);

		return $fixtures;
	}
}

testCase(AclRoleRepositoryTestCase::class);
