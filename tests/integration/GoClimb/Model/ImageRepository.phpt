<?php
/**
 * Test: ImageRepository test
 */

use GoClimb\Model\Entities\ContentPart;
use GoClimb\Model\Entities\File;
use GoClimb\Model\Entities\Image;
use GoClimb\Model\Repositories\ImageRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class ImageRepositoryTestCase extends DatabaseTestCase
{

	/** @var ImageRepository $imageRepository */
	private $imageRepository;


	public function __construct(ImageRepository $imageRepository)
	{
		parent::__construct();
		$this->imageRepository = $imageRepository;
	}


	public function testGetById()
	{
		Assert::null($this->imageRepository->getById(0));
		Assert::type(Image::class, $image = $this->imageRepository->getById(1));
		Assert::equal(1, $image->getId());
	}


	public function testMapping()
	{
		$image = $this->imageRepository->getById(1);

		Assert::type(File::class, $file = $image->getFile());
		Assert::equal(1, $file->getId());

		Assert::type(File::class, $thumbnailFile = $image->getThumbnailFile());
		Assert::equal(1, $thumbnailFile->getId());

		Assert::type(ContentPart::class, $contentPart = $image->getContentPart());
		Assert::equal(1, $contentPart->getId());

		Assert::equal(1920, $image->getWidth());
		Assert::equal(1080, $image->getHeight());
	}

}

testCase(ImageRepositoryTestCase::class);
