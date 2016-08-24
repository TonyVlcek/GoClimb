<?php
/**
 * Test: CompanyRepository test
 */

use GoClimb\Model\Entities\Company;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\CompanyRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class CompanyRepositoryTestCase extends DatabaseTestCase
{

	/** @var CompanyRepository */
	private $companyRepository;


	public function __construct(CompanyRepository $companyRepository)
	{
		parent::__construct();
		$this->companyRepository = $companyRepository;
	}


	public function testGetById()
	{
		Assert::null($this->companyRepository->getById(0));
		Assert::type(Company::class, $company = $this->companyRepository->getById(1));
		Assert::equal(1, $company->getId());
	}


	public function testMapping()
	{
		$company = $this->companyRepository->getById(1);

		Helpers::assertTypeRecursive(User::class, $company->getUsers());
		Assert::equal([1,2], Helpers::mapIds($company->getUsers()));

		Helpers::assertTypeRecursive(Wall::class, $company->getWalls());
		Assert::equal([1,2], Helpers::mapIds($company->getWalls()));
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		return [
			$userOne = (new User)->setEmail('aa@aa.aa')->setPassword('aaa'),
			$userTwo = (new User)->setEmail('bb@bb.bb')->setPassword('bbb'),
			$wallOne = (new Wall)->setName('Wall One'),
			$wallTwo = (new Wall)->setName('Wall Two'),
			(new Company)->setName('Company')->addUser($userOne)->addUser($userTwo)->addWall($wallOne)->addWall($wallTwo),
		];
	}
}

testCase(CompanyRepositoryTestCase::class);
