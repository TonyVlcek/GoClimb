<?php
/**
 * TEST: WallRepository test
 *
 * @author Tony Vlček
 */

use OnlineClimbing\Model\Entities\Article;
use OnlineClimbing\Model\Entities\Page;
use OnlineClimbing\Model\Entities\Role;
use OnlineClimbing\Model\Entities\Sector;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Entities\Wall;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Model\WallException;
use OnlineClimbing\Tests\Helpers;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../bootstrap.php';

class WallRepositoryTestCase extends DatabaseTestCase
{

	/** @var WallRepository */
	private $wallRepository;

	/** @var  UserRepository */
	private $userRepository;


	public function __construct(WallRepository $wallRepository, UserRepository $userRepository)
	{
		parent::__construct();
		$this->wallRepository = $wallRepository;
		$this->userRepository = $userRepository;
	}


	public function testGetById()
	{
		Assert::type(Wall::class, $wall = $this->wallRepository->getById(1));
		Assert::equal(1, $wall->getId());
	}


	public function testGetByName()
	{
		Assert::type(Wall::class, $wall = $this->wallRepository->getByName('Test Wall'));
		Assert::equal(1, $wall->getId());
	}


	public function testCreateWall()
	{
		//Test state before
		Assert::null($this->wallRepository->getById(3));

		//Create wall with an exception
		$user = $this->userRepository->getById(1);
		$that = $this;
		Assert::exception(function () use ($user, $that) {
			$that->wallRepository->createWall($user, 'Test Wall');
		}, WallException::class);

		//Create wall without exception
		Assert::type(Wall::class, $wall = $this->wallRepository->createWall($user, 'This Will Exist'));

		//Test state after
		Assert::equal('This Will Exist', $wall->getName());
	}


	public function testMapping()
	{
		$wall = $this->wallRepository->getById(1);

		Assert::type(User::class, $user = $wall->getUser());
		Assert::equal(1, $user->getId());

		Helpers::assertTypesRecursive(Role::class, $roles = $wall->getRoles());
		Assert::equal([1, 2], Helpers::mapIds($roles));

		Helpers::assertTypesRecursive(Article::class, $articles = $wall->getArticles());
		Assert::equal([1, 2], Helpers::mapIds($articles));

		Helpers::assertTypesRecursive(Sector::class, $sectors = $wall->getSectors());
		Assert::equal([1], Helpers::mapIds($sectors));

		Helpers::assertTypesRecursive(Page::class, $pages = $wall->getPages());
		Assert::equal([1], Helpers::mapIds($pages));
	}

}

testCase(WallRepositoryTestCase::class);
