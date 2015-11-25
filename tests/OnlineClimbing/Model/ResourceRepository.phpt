<?php
/**
 * Test: ResourceRepository test
 *
 * @author Tomáš Blatný
 */

use OnlineClimbing\Model\Entities\Resource;
use OnlineClimbing\Model\Repositories\ResourceRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../bootstrap.php";

class ResourceRepositoryTestCase extends DatabaseTestCase
{

	/** @var ResourceRepository */
	private $resourceRepository;


	public function __construct(ResourceRepository $resourceRepository)
	{
		parent::__construct();
		$this->resourceRepository = $resourceRepository;
	}


	public function testGetByName()
	{
		Assert::type(Resource::class, $resource = $this->resourceRepository->getByName('Resource 1'));
		Assert::equal('Resource 1', $resource->getName());
	}

}

testCase(ResourceRepositoryTestCase::class);
