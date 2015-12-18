<?php
/**
 * Test: AclResourceRepository test
 *
 * @author Tomáš Blatný
 */

use OnlineClimbing\Model\Entities\AclResource;
use OnlineClimbing\Model\Repositories\AclResourceRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class AclResourceRepositoryTestCase extends DatabaseTestCase
{

	/** @var AclResourceRepository */
	private $aclResourceRepository;


	public function __construct(AclResourceRepository $resourceRepository)
	{
		parent::__construct();
		$this->aclResourceRepository = $resourceRepository;
	}


	public function testGetByName()
	{
		Assert::null($this->aclResourceRepository->getByName("InvalidAclTest"));
		Assert::type(AclResource::class, $resource = $this->aclResourceRepository->getByName('Resource 1'));
		Assert::equal('Resource 1', $resource->getName());
	}

}

testCase(AclResourceRepositoryTestCase::class);
