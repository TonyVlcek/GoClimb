<?php
/**
 * TEST: PrivilegeRepository test
 *
 * @author Martin Mikšik
 */

use OnlineClimbing\Model\Entities\Privilege;
use OnlineClimbing\Model\Repositories\PrivilegeRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class PrivilegeRepositoryTestCase extends DatabaseTestCase
{

	/** @var PrivilegeRepository */
	private $privilegeRepository;


	public function __construct(PrivilegeRepository $privilegeRepository)
	{
		parent::__construct();
		$this->privilegeRepository = $privilegeRepository;
	}


	public function testGetByName()
	{
		Assert::type(Privilege::class, $this->privilegeRepository->getByName("edit"));
	}

}

testCase(PrivilegeRepositoryTestCase::class);
