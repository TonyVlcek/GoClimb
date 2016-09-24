<?php

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Article;
use GoClimb\Model\Rest\Utils;


class ArticleMapper
{

	/**
	 * @param Article[] $articles
	 * @return array
	 */
	public static function mapArray(array $articles)
	{
		$result = [];
		foreach ($articles as $key => $article) {
			$result[$article->getId()] = self::map($article);
		}

		return $result;
	}


	/**
	 * @param Article $article
	 * @return array
	 */
	public static function map(Article $article)
	{
		return [
			'id' => $article->getId(),
			'name' => $article->getName(),
			'content' => $article->getContent(),
			'author' => [
				'id' => $article->getAuthor()->getId(),
				'name' => $article->getAuthor()->getDisplayedName(),
			],
			'publishedDate' => Utils::formatDateTime($article->getPublishedDate()),
			'published' => $article->isPublished(),
		];
	}
}
