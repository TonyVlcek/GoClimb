<?php
/**
 * Test: ContentPartTest test
 */

use GoClimb\Model\Entities\ContentPart;
use GoClimb\Model\Entities\Page;
use GoClimb\Model\Repositories\ContentPartRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class ContentPartRepositoryTestCase extends DatabaseTestCase
{

	/** @var ContentPartRepository */
	private $contentPartRepository;


	public function __construct(ContentPartRepository $contentPartRepository)
	{
		parent::__construct();
		$this->contentPartRepository = $contentPartRepository;
	}


	public function testGetById()
	{
		Assert::null($this->contentPartRepository->getById(0));
		Assert::type(ContentPart::class, $cp = $this->contentPartRepository->getById(1));
		Assert::equal(1, $cp->getId());
	}


	public function testMapping()
	{
		$cp = $this->contentPartRepository->getById(1);

		Assert::type(Page::class, $page = $cp->getPage());
		Assert::equal(1, $page->getId());
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		return [
			$page = (new Page)->setName('Page'),
			(new ContentPart)->setPage($page)->setContent('Content')->setOrder(1)->setType(1),
		];
	}
}

testCase(ContentPartRepositoryTestCase::class);
