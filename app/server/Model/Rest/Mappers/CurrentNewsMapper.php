<?php

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\CurrentNews;
use GoClimb\Model\Rest\Utils;


class CurrentNewsMapper
{

	/**
	 * @param CurrentNews[] $news
	 * @return array
	 */
	public static function mapArray(array $news)
	{
		$result = [];
		foreach ($news as $key => $currentNews) {
			$result[$currentNews->getId()] = self::map($currentNews);
		}

		return $result;
	}


	/**
	 * @param CurrentNews $currentNews
	 * @return array
	 */
	public static function map(CurrentNews $currentNews)
	{
		return [
			'id' => $currentNews->getId(),
			'name' => $currentNews->getName(),
			'content' => $currentNews->getContent(),
			'author' => [
				'id' => $currentNews->getAuthor()->getId(),
				'name' => $currentNews->getAuthor()->getFullName(),
			],
			'publishedDate' => Utils::formatDateTime($currentNews->getPublishedDate()),
			'published' => $currentNews->isPublished(),
		];
	}
}
