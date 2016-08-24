<?php
/**
 * Test: WallRepository test
 */

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Entities\Article;
use GoClimb\Model\Entities\Company;
use GoClimb\Model\Entities\File;
use GoClimb\Model\Entities\Language;
use GoClimb\Model\Entities\Page;
use GoClimb\Model\Entities\RestToken;
use GoClimb\Model\Entities\AclRole;
use GoClimb\Model\Entities\Sector;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Entities\WallLanguage;
use GoClimb\Model\Repositories\CompanyRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Model\WallException;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Nette\Utils\DateTime;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class WallRepositoryTestCase extends DatabaseTestCase
{

	const WALL_NAME = 'Wall One';
	const NEW_WALL_NAME = 'Wall Two';


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
		Assert::type(Wall::class, $wall = $this->wallRepository->getByName(self::WALL_NAME));
		Assert::equal(1, $wall->getId());
	}


	public function testCreateWall()
	{
		//Test state before
		Assert::null($this->wallRepository->getById(0));

		//Create wall with an exception
		$company = $this->companyRepository->getById(1);
		Assert::exception(function () use ($company) {
			$this->wallRepository->createWall($company, self::WALL_NAME);
		}, WallException::class);

		//Create wall without exception
		Assert::type(Wall::class, $wall = $this->wallRepository->createWall($company, self::NEW_WALL_NAME));

		//Test state after
		Assert::equal(self::NEW_WALL_NAME, $wall->getName());
	}


	public function testMapping()
	{
		$wall = $this->wallRepository->getById(1);

		Helpers::assertTypeRecursive(User::class, $users = $wall->getCompany()->getUsers());
		Assert::equal([1], Helpers::mapIds($users));

		Helpers::assertTypeRecursive(AclRole::class, $roles = $wall->getRoles());
		Assert::equal([1], Helpers::mapIds($roles));

		Helpers::assertTypeRecursive(Article::class, $articles = $wall->getArticles());
		Assert::equal([1], Helpers::mapIds($articles));

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

		Helpers::assertTypeRecursive(User::class, $usersFavorites = $wall->getUsersFavorited());
		Assert::equal([1], Helpers::mapIds($usersFavorites));


		Helpers::assertTypeRecursive(WallLanguage::class, $wallLanguages = $wall->getWallLanguages());
		Assert::equal([1], Helpers::mapIds($wallLanguages));

		Assert::type(WallLanguage::class, $wallLanguage = $wall->getPrimaryLanguage());
		Assert::equal(1, $wallLanguage->getId());

		Assert::type(Language::class, $language = $wallLanguage->getLanguage());
		Assert::equal(1, $language->getId());

		Helpers::assertTypeRecursive(WallLanguage::class, $wallLanguages = $language->getWallLanguages());
		dump($wallLanguages);
		Assert::equal([1], Helpers::mapIds($wallLanguages));
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		$fixtures = [];
		$fixtures[] = $wall = (new Wall)->setName(self::WALL_NAME);
		$fixtures[] = $company = (new Company)->setName('Company')->addWall($wall);
		$fixtures[] = $user = (new User)->setEmail('aa@aa.aa')->setPassword('aaa')->addCompany($company)->addFavoriteWall($wall);
		$fixtures[] = $role = (new AclRole)->setName('Role')->setWall($wall);
		$fixtures[] = $article = (new Article)->setName('Article')->setWall($wall)->setContent('Content');
		$fixtures[] = $sector = (new Sector)->setName('Sector')->setWall($wall);
		$fixtures[] = $page = (new Page)->setName('Page')->setWall($wall);
		$fixtures[] = $app = (new Application)->setName('App')->setDescription('Description')->setToken('Token')->setWall($wall);
		$fixtures[] = $restToken = (new RestToken)->setToken('Token')->setUser($user)->setWall($wall)->setRemoteIp('192.168.0.1')->setExpiration(new DateTime('+1 day'));
		$fixtures[] = $file = (new File)->setName('File')->setPath('Path')->setWall($wall);
		$fixtures[] = $lang = (new Language)->setName('Language')->setConst('language')->setShortcut('lang');
		$fixtures[] = $wallLang = (new WallLanguage)->setWall($wall)->setLanguage($lang)->setUrl('http://url.com');

		$company->addUser($user);
		$lang->addWallLanguage($wallLang);
		$wall->setCompany($company)->addRole($role)->addArticle($article)->addSector($sector)->addPage($page)->setApplication($app)->addRestToken($restToken)->addFile($file)->addUserFavorite($user)->addWallLanguage($wallLang)->setPrimaryLanguage($wallLang);


		return $fixtures;
	}
}

testCase(WallRepositoryTestCase::class);
