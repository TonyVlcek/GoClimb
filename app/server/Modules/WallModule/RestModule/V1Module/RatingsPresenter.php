<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\Rating;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\RatingRepository;
use GoClimb\Model\Rest\Mappers\RatingMapper;
use GoClimb\Model\Rest\Updaters\RatingUpdater;


class RatingsPresenter extends BaseV1Presenter
{


	/** @var RatingRepository */
	private $ratingRepository;

	/** @var RatingUpdater */
	private $ratingUpdater;


	public function __construct(RatingRepository $ratingRepository, RatingUpdater $ratingUpdater)
	{
		parent::__construct();
		$this->ratingRepository = $ratingRepository;
		$this->ratingUpdater = $ratingUpdater;
	}


	public function actionGet($id = NULL)
	{
		if ($id === NULL) {
			$this->sendMethodNotAllowed();
		} elseif (!$rating = $this->ratingRepository->getById($id)) {
			$this->sendNotFound();
		} else {
			$this->sendMethodNotAllowed();
		}

		$this->addRatingData($rating);
	}


	public function actionPost($id = NULL)
	{
		$this->checkPermissions();
		try {
			if ($id === NULL) {
				$rating = new Rating;
				$rating->setAuthor($this->getUser()->getUserEntity());
			} else {
				if (!$rating = $this->ratingRepository->getById($id)) {
					$this->sendNotFound();
				}
			}

			if ($rating->getAuthor()->getId() !== $this->getUser()->getId()) {
				$this->sendForbidden();
			}

			$this->ratingUpdater->updateRating($rating, $this->getData('rating'));
			$this->addRatingData($rating);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	private function addRatingData($rating)
	{
		$this->addData('rating', RatingMapper::map($rating));
	}


	private function checkPermissions()
	{
		if (!$this->user->isLoggedIn()) {
			$this->sendForbidden();
		}
	}

}
