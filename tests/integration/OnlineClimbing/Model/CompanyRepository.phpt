<?php
/**
 * Test: CompanyRepository test
 *
 * @author Tomáš Blatný
 */

use OnlineClimbing\Model\Entities\Company;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Entities\Wall;
use OnlineClimbing\Model\Repositories\CompanyRepository;
use OnlineClimbing\Tests\Helpers;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

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

		Helpers::assertTypesRecursive(User::class, $company->getUsers());
		Assert::equal([1,2], Helpers::mapIds($company->getUsers()));

		Helpers::assertTypesRecursive(Wall::class, $company->getWalls());
		Assert::equal([1,2], Helpers::mapIds($company->getWalls()));
	}

}

testCase(CompanyRepositoryTestCase::class);
