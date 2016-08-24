<?php
/**
 * Test: AclResourceRepository test
 */

use GoClimb\Model\Entities\AclResource;
use GoClimb\Model\Repositories\AclResourceRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

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
		Assert::null($this->aclResourceRepository->getByName(AclResourceRepository::class . 'InvalidAclTest'));
		Assert::type(AclResource::class, $resource = $this->aclResourceRepository->getByName(AclResourceRepository::class));
		Assert::equal(AclResourceRepository::class, $resource->getName());
	}

	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		return [
			(new AclResource)->setName(AclResourceRepository::class),
		];
	}
}

testCase(AclResourceRepositoryTestCase::class);
