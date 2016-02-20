<?php
/**
 * TEST: WallRepository test
 *
 * @author Tony Vlček
 */

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Entities\Article;
use GoClimb\Model\Entities\File;
use GoClimb\Model\Entities\Page;
use GoClimb\Model\Entities\RestToken;
use GoClimb\Model\Entities\AclRole;
use GoClimb\Model\Entities\Sector;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\CompanyRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Model\WallException;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class WallRepositoryTestCase extends DatabaseTestCase
{

	/** @var WallRepository */
	private $wallRepository;

	/** @var CompanyRepository */
	private $companyRepository;


	public function __construct(WallRepository $wallRepository, CompanyRepository $companyRepository)
	{
		parent::__construct();
		$this->wallRepository = $wallRepository;
		$this->companyRepository = $companyRepository;
	}


	public function testGetById()
	{
		Assert::null($this->wallRepository->getById(0));
		Assert::type(Wall::class, $wall = $this->wallRepository->getById(1));
		Assert::equal(1, $wall->getId());
	}


	public function testGetByName()
	{
		Assert::null($this->wallRepository->getByName('InvalidWallTest'));
		Assert::type(Wall::class, $wall = $this->wallRepository->getByName('Test Wall'));
		Assert::equal(1, $wall->getId());
	}


	public function testGetByBaseUrl()
	{
		Assert::null($this->wallRepository->getByBaseUrl('NotExistingUrl'));
		Assert::type(Wall::class, $wall = $this->wallRepository->getByBaseUrl('http://test-wall.cz/'));
		Assert::equal(1, $wall->getId());
	}


	public function testCreateWall()
	{
		//Test state before
		Assert::null($this->wallRepository->getById(0));

		//Create wall with an exception
		$company = $this->companyRepository->getById(1);
		Assert::exception(function () use ($company) {
			$this->wallRepository->createWall($company, 'Test Wall');
		}, WallException::class);

		//Create wall without exception
		Assert::type(Wall::class, $wall = $this->wallRepository->createWall($company, 'This Will Exist'));

		//Test state after
		Assert::equal('This Will Exist', $wall->getName());
	}


	public function testMapping()
	{
		$wall = $this->wallRepository->getById(1);

		Helpers::assertTypeRecursive(User::class, $users = $wall->getCompany()->getUsers());
		Assert::equal([1, 2], Helpers::mapIds($users));

		Helpers::assertTypeRecursive(AclRole::class, $roles = $wall->getRoles());
		Assert::equal([1, 2], Helpers::mapIds($roles));

		Helpers::assertTypeRecursive(Article::class, $articles = $wall->getArticles());
		Assert::equal([1, 2], Helpers::mapIds($articles));

		Helpers::assertTypeRecursive(Sector::class, $sectors = $wall->getSectors());
		Assert::equal([1], Helpers::mapIds($sectors));

		Helpers::assertTypeRecursive(Page::class, $pages = $wall->getPages());
		Assert::equal([1], Helpers::mapIds($pages));

		Assert::type(Application::class, $app = $wall->getApplication());
		Assert::equal(1, $app->getId());

		Helpers::assertTypeRecursive(RestToken::class, $restTokens = $wall->getRestTokens());
		Assert::equal([1], Helpers::mapIds($restTokens));

		Helpers::assertTypeRecursive(File::class, $files = $wall->getFiles());
		Assert::equal([1], Helpers::mapIds($files));

		Helpers::assertTypeRecursive(User::class, $files = $wall->getUsersFavorited());
		Assert::equal([1, 2], Helpers::mapIds($files));
	}

}

testCase(WallRepositoryTestCase::class);
