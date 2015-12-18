<?php
/**
 * TEST: AclPrivilegeRepository test
 *
 * @author Martin Mikšik
 */

use OnlineClimbing\Model\Entities\AclPrivilege;
use OnlineClimbing\Model\Repositories\AclPrivilegeRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class AclPrivilegeRepositoryTestCase extends DatabaseTestCase
{

	/** @var AclPrivilegeRepository */
	private $aclPrivilegeRepository;


	public function __construct(AclPrivilegeRepository $privilegeRepository)
	{
		parent::__construct();
		$this->aclPrivilegeRepository = $privilegeRepository;
	}


	public function testGetByName()
	{
		Assert::null($this->aclPrivilegeRepository->getByName("InvalidAclTest"));
		Assert::type(AclPrivilege::class, $this->aclPrivilegeRepository->getByName("edit"));
	}

}

testCase(AclPrivilegeRepositoryTestCase::class);
