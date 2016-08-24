<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\Article;
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


	public function actionDefault($id = NULL)
	{
		switch ($this->getHttpRequest()->getMethod()) {
			case 'GET':
				if ($id === NULL) {
					$this->addArticlesData();
					break;
				}

				$article = $this->articleRepository->getById($id);
				$this->addArticleData($article);
				break;
			case 'POST':
				if ($id === NULL) {
					$this->create();
					break;
				}
				$this->update($id);
				break;
			case 'DELETE':
				if ($id === NULL) {
					$this->sendUnprocessableEntity('Parameter id is missing.');
					break;
				}
				$this->delete($id);
				break;

			default:
				$this->sendMethodNotAllowed();
				break;
		}
	}


	public function addArticlesData()
	{
		$articles = $this->articleRepository->getByWall($this->wall);
		$this->addData('articles', ArticleMapper::mapArray($articles));
	}


	public function addArticleData(Article $article)
	{
		$this->addData('article', ArticleMapper::map($article));
	}


	public function create()
	{
		try {
			$article = new Article;
			$author = $this->getUser()->getUserEntity();
			$article->setAuthor($author);
			$article->setWall($this->wall);
			$this->articleUpdater->updateArticle($article, $this->getData('article'));
			$this->addArticleData($article);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	public function update($id)
	{
		try {
			$article = $this->articleRepository->getById($id);
			$this->articleUpdater->updateArticle($article, $this->getData('article'));
			$this->addArticleData($article);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	public function delete($id)
	{
		try {
			$article = $this->articleRepository->getById($id);
			$this->articleRepository->remove($article);
			$this->addArticleData($article);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}

}
