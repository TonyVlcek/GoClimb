<?php
/**
 * TEST: UserRepository test
 *
 * @author Tomáš Blatný
 */

use Nette\Security\Passwords;
use OnlineClimbing\Model\Entities\Article;
use OnlineClimbing\Model\Entities\RestToken;
use OnlineClimbing\Model\Entities\Route;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Helpers;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../bootstrap.php';

class UserRepositoryTestCase extends DatabaseTestCase
{

	/** @var UserRepository */
	private $userRepository;

	/** @var WallRepository */
	private $wallRepository;


	public function __construct(UserRepository $userRepository, WallRepository $wallRepository)
	{
		parent::__construct();
		$this->userRepository = $userRepository;
		$this->wallRepository = $wallRepository;
	}


	public function testGetById()
	{
		Assert::type(User::class, $adminUser = $this->userRepository->getById(1));
		Assert::equal(1, $adminUser->getId());
	}


	public function testGetByName()
	{
		Assert::type(User::class, $testUser = $this->userRepository->getByName('test'));
		Assert::equal(2, $testUser->getId());
	}


	public function testCreateUser()
	{
		Assert::type(User::class, $testUser = $this->userRepository->createUser('a', 'b'));
		Assert::equal('a', $testUser->getName());
		Assert::true(Passwords::verify('b', $testUser->getPassword()));

		//Test state after
		Assert::equal($testUser, $this->userRepository->getByName('a'));
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


	public function testMapping()
	{
		$user = $this->userRepository->getById(1);

		Helpers::assertTypesRecursive(Article::class, $articles = $user->getArticles());
		Assert::equal([1, 2], Helpers::mapIds($articles));

		Helpers::assertTypesRecursive(Route::class, $routes = $user->getBuiltRoutes());
		Assert::equal([1], Helpers::mapIds($routes));

		Helpers::assertTypesRecursive(RestToken::class, $restTokens = $user->getRestTokens());
		Assert::equal([1], Helpers::mapIds($restTokens));
	}

}

testCase(UserRepositoryTestCase::class);
