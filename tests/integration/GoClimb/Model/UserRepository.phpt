<?php
/**
 * Test: UserRepository test
 */

use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Sector;
use Nette\Security\Passwords;
use GoClimb\Model\Entities\Article;
use GoClimb\Model\Entities\Company;
use GoClimb\Model\Entities\LoginToken;
use GoClimb\Model\Entities\RestToken;
use GoClimb\Model\Entities\Route;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Nette\Utils\DateTime;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

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
		Assert::null($this->userRepository->getById(0));
		Assert::type(User::class, $adminUser = $this->userRepository->getById(1));
		Assert::equal(1, $adminUser->getId());
	}


	public function testGetByNick()
	{
		Assert::null($this->userRepository->getByNick('invalidUserTest'));
		Assert::type(User::class, $testUser = $this->userRepository->getByNick('User One'));
		Assert::equal(1, $testUser->getId());
	}


	public function testGetByEmail()
	{
		Assert::null($this->userRepository->getByEmail('0@test.com'));
		Assert::type(User::class, $testUser = $this->userRepository->getByEmail('aa@aa.aa'));
		Assert::equal(1, $testUser->getId());
	}


	public function testCreateUser()
	{
		Assert::type(User::class, $testUser = $this->userRepository->createUser('a@b.c', 'b'));
		Assert::equal('a@b.c', $testUser->getEmail());
		Assert::true(Passwords::verify('b', $testUser->getPassword()));

		//Test state after
		Assert::equal($testUser, $this->userRepository->getByEmail('a@b.c'));
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

		Helpers::assertTypeRecursive(Article::class, $articles = $user->getArticles());
		Assert::equal([1], Helpers::mapIds($articles));

		/*Helpers::assertTypeRecursive(Route::class, $routes = $user->getBuiltRoutes());
		Assert::equal([1], Helpers::mapIds($routes));*/

		Helpers::assertTypeRecursive(LoginToken::class, $loginTokens = $user->getLoginTokens());
		Assert::equal([1], Helpers::mapIds($loginTokens));

		Helpers::assertTypeRecursive(RestToken::class, $restTokens = $user->getRestTokens());
		Assert::equal([1], Helpers::mapIds($restTokens));

		Helpers::assertTypeRecursive(Wall::class, $favoriteWalls = $user->getFavoriteWalls());
		Assert::equal([1, 2], Helpers::mapIds($favoriteWalls));

		Helpers::assertTypeRecursive(Company::class, $companies = $user->getCompanies());
		Assert::equal([1], Helpers::mapIds($companies));
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		$fixtures = [];
		$fixtures[] = $wallOne = (new Wall)->setName('Wall One');
		$fixtures[] = $wallTwo = (new Wall)->setName('Wall Two');
		$fixtures[] = $userOne = (new User)->setNick('User One')->setEmail('aa@aa.aa')->setPassword('aaa')->addFavoriteWall($wallOne)->addFavoriteWall($wallTwo);
		$fixtures[] = $userTwo = (new User)->setEmail('bb@bb.bb')->setPassword('bbb')->addFavoriteWall($wallOne)->addFavoriteWall($wallTwo);
		$fixtures[] = $article = (new Article)->setName('Article')->setWall($wallOne)->setPublishedDate(new DateTime('-7 days'))->setAuthor($userOne)->setContent('Content');
		$fixtures[] = $sector = (new Sector)->setName('Sector')->setWall($wallOne);
		$fixtures[] = $line = (new Line)->setName('Line One')->setSector($sector);
//		$fixtures[] = $route = (new Route)->setName('Test Route')->setBuilder($userOne)->setLine($line);
		$fixtures[] = $loginToken = (new LoginToken)->setToken('Login Token')->setUser($userOne)->setExpiration(new DateTime('+1 day'))->setLongTerm(0);
		$fixtures[] = $restToken = (new RestToken)->setUser($userOne)->setWall($wallOne)->setToken('Rest Token')->setRemoteIp('192.168.0.1')->setExpiration(new DateTime('+1 day'));
		$fixtures[] = $company = (new Company)->setName('Company')->addUser($userOne)->addWall($wallOne);
		$wallOne->addUserFavorite($userOne)->addUserFavorite($userTwo);
		$wallTwo->addUserFavorite($userOne)->addUserFavorite($userTwo);
		$userOne->addArticle($article)/*->addBuiltRoute($route)*/->addLoginToken($loginToken)->addRestToken($restToken)->addCompany($company);

		return $fixtures;
	}
}

testCase(UserRepositoryTestCase::class);
