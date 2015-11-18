<?php
/**
 * TEST: UserRepository test
 *
 * @author Tomáš Blatný
 */

use Nette\DI\Container;
use Nette\Security\Passwords;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Helpers;
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

	/** @var UserRepository */
	private $userRepository;

	/** @var WallRepository */
	private $wallRepository;

	public function __construct(Container $container)
	{
		parent::__construct($container);
		$this->userRepository = $this->container->getByType(UserRepository::class);
		$this->wallRepository = $this->container->getByType(WallRepository::class);
	}


	public function testGetById()
	{
		Assert::truthy($adminUser = $this->userRepository->getById(self::ADMIN_USER_ID));
		Assert::equal(self::ADMIN_USER_ID, $adminUser->getId());
		Assert::equal(self::ADMIN_USER_NAME, $adminUser->getName());
	}


	public function testGetByName()
	{
		Assert::truthy($testUser = $this->userRepository->getByName(self::TEST_USER_NAME));
		Assert::equal(self::TEST_USER_ID, $testUser->getId());
		Assert::equal(self::TEST_USER_NAME, $testUser->getName());
	}


	public function testCreateUser()
	{
		Assert::truthy($testUser = $this->userRepository->createUser('a', 'b'));
		Assert::equal('a', $testUser->getName());
		Assert::true(Passwords::verify('b', $testUser->getPassword()));
	}


	public function testFavoriteWalls()
	{
		$user1 = $this->userRepository->getById(1);
		$wall1 = $this->wallRepository->getById(1);
		$user2 = $this->userRepository->getById(2);
		$wall2 = $this->wallRepository->getById(2);

		//test state
		Assert::equal([1, 2], Helpers::mapIds($user1->getFavoriteWalls()));
		Assert::equal([1, 2], Helpers::mapIds($wall1->getUsersFavorited()));

		//remove
		$this->userRepository->removeFavoriteWall($user1, $wall1);

		//test state - bi-directional
		Assert::equal([2], Helpers::mapIds($user1->getFavoriteWalls()));
		Assert::equal([2], Helpers::mapIds($wall1->getUsersFavorited()));

		//test one favorite wall
			//user -> wall
		Assert::true($user1->hasFavoriteWall($wall2));
		Assert::false($user1->hasFavoriteWall($wall1));

			//wall -> user
		Assert::true($wall1->hasUserFavorited($user2));
		Assert::false($wall1->hasUserFavorited($user1));

		//add
		$this->userRepository->addFavoriteWall($user1, $wall1);

		//test state
		Assert::equal([1, 2], Helpers::mapIds($user1->getFavoriteWalls()));
		Assert::equal([1, 2], Helpers::mapIds($wall1->getUsersFavorited()));
	}

}

testCase(new UserRepositoryTestCase($container));
