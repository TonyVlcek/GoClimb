<?php

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Rating;
use GoClimb\Model\Rest\Utils;


class RatingMapper
{

	/**
	 * @param Rating[] $ratings
	 * @return array
	 */
	public static function mapArray(array $ratings)
	{
		$result = [];
		foreach ($ratings as $key => $rating) {
			$result[$rating->getId()] = self::map($rating);
		}

		return $result;
	}


	/**
	 * @param Rating $rating
	 * @return array
	 */
	public static function map(Rating $rating)
	{
		return [
			'id' => $rating->getId(),
			'note' => $rating->getNote(),
			'rating' => $rating->getRating(),
			'route' => [
				'id'=> $rating->getRoute()->getId()
			],
			'author' => [
				'id' => $rating->getAuthor()->getId(),
				'name' => $rating->getAuthor()->getDisplayedName(),
			],
			'dateCreated' => Utils::formatDateTime($rating->getCreatedDate()),
		];
	}
}
