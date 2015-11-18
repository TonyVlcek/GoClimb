<?php
/**
 * Test: ArticleRepository test
 *
 * @author Tony Vlček
 */

use Nette\DI\Container;
use OnlineClimbing\Model\Repositories\ArticleRepository;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Helpers;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


/** @var Container $container */
$container = require __DIR__ . "/../../bootstrap.php";

class ArticleRepositoryTestCase extends DatabaseTestCase
{

	/** @var ArticleRepository */
	private $articleRepository;

	/** @var WallRepository */
	private $wallRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(Container $container)
	{
		parent::__construct($container);

		$this->articleRepository = $container->getByType(ArticleRepository::class);
		$this->wallRepository = $container->getByType(WallRepository::class);
		$this->userRepository = $container->getByType(UserRepository::class);
	}


	public function testGetById()
	{
		Assert::truthy($article = $this->articleRepository->getById(1));
		Assert::equal(1, $article->getId());
		Assert::equal(1, $article->getAuthor()->getId());
		Assert::equal(1, $article->getWall()->getId());
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
}

testCase(new ArticleRepositoryTestCase($container));
