<?php
/**
 * Test: ArticleRepository test
 *
 * @author Tony Vlček
 */

use GoClimb\Model\Entities\Article;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\ArticleRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class ArticleRepositoryTestCase extends DatabaseTestCase
{

	/** @var ArticleRepository */
	private $articleRepository;

	/** @var WallRepository */
	private $wallRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(ArticleRepository $articleRepository, WallRepository $wallRepository, UserRepository $userRepository)
	{
		parent::__construct();
		$this->articleRepository = $articleRepository;
		$this->wallRepository = $wallRepository;
		$this->userRepository = $userRepository;
	}


	public function testGetById()
	{
		Assert::null($this->articleRepository->getById(0));
		Assert::type(Article::class, $article = $this->articleRepository->getById(1));
		Assert::equal(1, $article->getId());
	}


	public function testGetByWall()
	{
		Assert::equal([1, 2], Helpers::mapIds($this->articleRepository->getByWall($this->wallRepository->getById(1), TRUE)));
		Assert::equal([3, 4], Helpers::mapIds($this->articleRepository->getByWall($this->wallRepository->getById(2), NULL)));
		Assert::equal([4], Helpers::mapIds($this->articleRepository->getByWall($this->wallRepository->getById(2), FALSE)));
	}


	public function testGetGlobal()
	{
		Assert::equal([5], Helpers::mapIds($this->articleRepository->getGlobal(TRUE)));
		Assert::equal([5, 6], Helpers::mapIds($this->articleRepository->getGlobal(NULL)));
		Assert::equal([6], Helpers::mapIds($this->articleRepository->getGlobal(FALSE)));
	}


	public function testMapping()
	{
		$article = $this->articleRepository->getById(1);

		Assert::type(User::class, $article->getAuthor());
		Assert::equal(1, $article->getAuthor()->getId());

		Assert::type(Wall::class, $article->getWall());
		Assert::equal(1, $article->getWall()->getId());
	}
}

testCase(ArticleRepositoryTestCase::class);
