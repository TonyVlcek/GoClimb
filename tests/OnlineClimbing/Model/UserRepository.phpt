<?php
/**
 * TEST: UserRepository test
 *
 * @author Tomáš Blatný
 */

use Nette\DI\Container;
use Nette\Security\Passwords;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


/** @var Container $container */
$container = require __DIR__ . '/../../bootstrap.php';

class UserRepositoryTestCase extends DatabaseTestCase
{

	const ADMIN_USER_ID = 1;
	const TEST_USER_ID = 2;

	const ADMIN_USER_NAME = 'admin';
	const TEST_USER_NAME = 'test';


	public function testGetById()
	{
		/** @var UserRepository $userRepository */
		$userRepository = $this->container->getByType(UserRepository::class);
		Assert::truthy($adminUser = $userRepository->getById(self::ADMIN_USER_ID));
		Assert::equal(self::ADMIN_USER_ID, $adminUser->getId());
		Assert::equal(self::ADMIN_USER_NAME, $adminUser->getName());
	}


	public function testGetByName()
	{
		/** @var UserRepository $userRepository */
		$userRepository = $this->container->getByType(UserRepository::class);
		Assert::truthy($testUser = $userRepository->getByName(self::TEST_USER_NAME));
		Assert::equal(self::TEST_USER_ID, $testUser->getId());
		Assert::equal(self::TEST_USER_NAME, $testUser->getName());
	}


	public function testCreateUser()
	{
		/** @var UserRepository $userRepository */
		$userRepository = $this->container->getByType(UserRepository::class);
		Assert::truthy($testUser = $userRepository->createUser('a', 'b'));
		Assert::equal('a', $testUser->getName());
		Assert::true(Passwords::verify('b', $testUser->getPassword()));
	}
}

testCase(new UserRepositoryTestCase($container));
