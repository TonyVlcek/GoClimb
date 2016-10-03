<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\Article;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\ArticleRepository;
use GoClimb\Model\Rest\Mappers\ArticleMapper;
use GoClimb\Model\Rest\Updaters\ArticleUpdater;


class ArticlesPresenter extends BaseV1Presenter
{

	/** @var ArticleRepository */
	private $articleRepository;

	/** @var ArticleUpdater */
	private $articleUpdater;

	/** @var UserFacade */
	private $userFacade;


	public function __construct(ArticleRepository $articleRepository, ArticleUpdater $articleUpdater, UserFacade $userFacade)
	{
		parent::__construct();
		$this->articleRepository = $articleRepository;
		$this->articleUpdater = $articleUpdater;
		$this->userFacade = $userFacade;
	}


	public function actionGet($id = NULL)
	{
		$this->checkPermissions();
		if ($id === NULL) {
			$this->addArticlesData();
		} elseif (!$article = $this->articleRepository->getById($id)) {
			$this->sendNotFound();
		} else {
			$this->addArticleData($article);
		}
	}


	public function actionPost($id = NULL)
	{
		$this->checkPermissions();
		try {
			if ($id === NULL) {
				$article = new Article;
				$article->setAuthor($this->getUser()->getUserEntity());
				$article->setWall($this->wall);
			} else {
				if (!$article = $this->articleRepository->getById($id)) {
					$this->sendNotFound();
				}
				if ($article->getWall() !== $this->wall) {
					$this->sendNotFound();
				}
			}
			$this->articleUpdater->updateArticle($article, $this->getData('article'));
			$this->addArticleData($article);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	public function actionDelete($id = NULL)
	{
		$this->checkPermissions();
		try {
			if (!$id || !$article = $this->articleRepository->getById($id)) {
				$this->sendNotFound();
			} else {
				$this->articleRepository->remove($article);
				$this->addArticleData($article);
			}
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	private function addArticlesData()
	{
		$articles = $this->articleRepository->getByWall($this->wall);
		$this->addData('articles', ArticleMapper::mapArray($articles));
	}


	private function addArticleData(Article $article)
	{
		$this->addData('article', ArticleMapper::map($article));
	}


	private function checkPermissions()
	{
		if (!$this->user->isAllowed(AclResource::ADMIN_ARTICLES)) {
			$this->sendForbidden();
		}
	}

}
