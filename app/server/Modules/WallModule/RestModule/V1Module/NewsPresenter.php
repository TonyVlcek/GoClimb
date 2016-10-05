<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\News;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\NewsRepository;
use GoClimb\Model\Rest\Mappers\NewsMapper;
use GoClimb\Model\Rest\Updaters\NewsUpdater;


class NewsPresenter extends BaseV1Presenter
{

	/** @var NewsRepository */
	private $newsRepository;

	/** @var NewsUpdater */
	private $newsUpdater;

	/** @var UserFacade */
	private $userFacade;


	public function __construct(NewsRepository $newsRepository, NewsUpdater $newsUpdater, UserFacade $userFacade)
	{
		parent::__construct();
		$this->newsRepository = $newsRepository;
		$this->newsUpdater = $newsUpdater;
		$this->userFacade = $userFacade;
	}


	public function actionGet($id = NULL)
	{
		$this->checkPermissions();
		if ($id === NULL) {
			$this->addAllNewsData();
		} elseif (!$news = $this->newsRepository->getById($id)) {
			$this->sendNotFound();
		} else {
			if ($news->getWall() !== $this->wall) {
				$this->sendNotFound();
			}
			$this->addNewsData($news);
		}
	}


	public function actionPost($id = NULL)
	{
		$this->checkPermissions();
		try {
			if ($id === NULL) {
				$news = new News;
				$news->setAuthor($this->getUser()->getUserEntity());
				$news->setWall($this->wall);
			} else {
				if (!$news = $this->newsRepository->getById($id)) {
					$this->sendNotFound();
				}
			}
			$this->newsUpdater->updateNews($news, $this->getData('news'));
			$this->addNewsData($news);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	public function actionDelete($id = NULL)
	{
		$this->checkPermissions();
		try {
			if (!$id || !$news = $this->newsRepository->getById($id)) {
				$this->sendNotFound();
			} else {
				$this->newsRepository->remove($news);
				$this->addNewsData($news);
			}
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	private function addAllNewsData()
	{
		$news = $this->newsRepository->getByWall($this->wall);
		$this->addData('news', NewsMapper::mapArray($news));
	}


	private function addNewsData(News $news)
	{
		$this->addData('news', NewsMapper::map($news));
	}


	private function checkPermissions()
	{
		if (!$this->user->isAllowed(AclResource::ADMIN_NEWS)) {
			$this->sendForbidden();
		}
	}

}
