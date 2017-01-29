<?php

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\Rating;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\RatingRepository;
use GoClimb\Model\Repositories\RouteRepository;
use GoClimb\Model\Rest\Utils;
use Nette\Utils\DateTime;
use stdClass;


class RatingUpdater
{

	/** @var RatingRepository */
	private $ratingRepository;

	/** @var RouteRepository */
	private $routeRepository;

	public function __construct(RatingRepository $ratingRepository, RouteRepository $routeRepository)
	{
		$this->ratingRepository = $ratingRepository;
		$this->routeRepository = $routeRepository;
	}


	/**
	 * @param Rating $rating
	 * @param stdClass $data
	 * @throws MappingException
	 * @return Rating
	 */
	public function updateRating(Rating $rating, stdClass $data = NULL)
	{
		if (!$data) {
			throw MappingException::invalidData();
		}

		Utils::updateProperties($rating, $data, [
			'note' => TRUE,
		]);

		Utils::checkProperty($data, 'route', TRUE);
		if (!$data->route->id){
			throw MappingException::invalidField('route', TRUE);
		}

		if(!$route = $this->routeRepository->getById($data->route->id)){
			throw MappingException::invalidId('route');
		}

		$rating->setRoute($route);

		Utils::checkProperty($data, 'rating', TRUE);
		if ($data->rating < 0 && 6 > $data->rating) {
			throw MappingException::invalidValue('rating', $data->rating);
		}
		$rating->setRating($data->rating);

		$rating->setCreatedDate(new DateTime('now'));

		$this->ratingRepository->save($rating);

		return $rating;
	}

}
