<?php

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\Article;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\ArticleRepository;
use GoClimb\Model\Rest\Utils;
use GoClimb\Security\User;
use Nette\Utils\DateTime;
use stdClass;


class ArticleUpdater
{

	/** @var ArticleRepository */
	private $articleRepository;


	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}


	/**
	 * @param Article $article
	 * @param stdClass $data
	 * @throws MappingException
	 * @return Article
	 */
	public function updateArticle(Article $article, stdClass $data = NULL)
	{
		if (!$data) {
			throw MappingException::invalidData();
		}

		Utils::updateProperties($article, $data, [
			'name' => TRUE,
			'content' => TRUE,
		]);

		if (isset($data->published) && !$article->isPublished() && $data->published) {
			$article->publish();
		}

		$this->articleRepository->save($article);

		return $article;
	}

}
