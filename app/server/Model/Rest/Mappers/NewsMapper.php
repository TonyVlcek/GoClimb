<?php

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\News;
use GoClimb\Model\Rest\Utils;


class NewsMapper
{

	/**
	 * @param News[] $allNews
	 * @return array
	 */
	public static function mapArray(array $allNews)
	{
		$result = [];
		foreach ($allNews as $key => $news) {
			$result[$news->getId()] = self::map($news);
		}

		return $result;
	}


	/**
	 * @param News $news
	 * @return array
	 */
	public static function map(News $news)
	{
		return [
			'id' => $news->getId(),
			'name' => $news->getName(),
			'author' => [
				'id' => $news->getAuthor()->getId(),
				'name' => $news->getAuthor()->getFullName(),
			],
			'publishedDate' => Utils::formatDateTime($news->getPublishedDate()),
			'published' => $news->isPublished(),
		];
	}
}
