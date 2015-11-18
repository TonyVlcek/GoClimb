<?php
/**
 * Test: ResourceRepository test
 *
 * @author Tomáš Blatný
 */

use Nette\DI\Container;
use OnlineClimbing\Model\Repositories\ResourceRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


/** @var Container $container */
$container = require __DIR__ . "/../../bootstrap.php";

class ResourceRepositoryTestCase extends DatabaseTestCase
{

	public function testGetByName()
	{
		/** @var ResourceRepository $resourceRepository */
		$resourceRepository = $this->container->getByType(ResourceRepository::class);
		Assert::truthy($resource = $resourceRepository->getByName('Resource 1'));
		Assert::equal('Resource 1', $resource->getName());
	}

}

testCase(new ResourceRepositoryTestCase($container));
