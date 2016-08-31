<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\CurrentNews;
use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\CurrentNewsRepository;
use GoClimb\Model\Rest\Mappers\CurrentNewsMapper;
use GoClimb\Model\Rest\Updaters\CurrentNewsUpdater;


class NewsPresenter extends BaseV1Presenter
{

	/** @var CurrentNewsRepository */
	private $currentNewsRepository;

	/** @var CurrentNewsUpdater */
	private $currentNewsUpdater;

	/** @var UserFacade */
	private $userFacade;


	public function __construct(CurrentNewsRepository $currentNewsRepository, CurrentNewsUpdater $currentNewsUpdater, UserFacade $userFacade)
	{
		parent::__construct();
		$this->currentNewsRepository = $currentNewsRepository;
		$this->currentNewsUpdater = $currentNewsUpdater;
		$this->userFacade = $userFacade;
	}


	public function actionDefault($id = NULL)
	{
		switch ($this->getHttpRequest()->getMethod()) {
			case 'GET':
				if ($id === NULL) {
					$this->addNewsData();
					break;
				}

				$currentNews = $this->currentNewsRepository->getById($id);
				$this->addCurrentNewsData($currentNews);
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


	public function addNewsData()
	{
		$news = $this->currentNewsRepository->getByWall($this->wall);
		$this->addData('news', CurrentNewsMapper::mapArray($news));
	}


	public function addCurrentNewsData(CurrentNews $currentNews)
	{
		$this->addData('currentNews', CurrentNewsMapper::map($currentNews));
	}


	public function create()
	{
		try {
			$currentNews = new CurrentNews;
			$author = $this->getUser()->getUserEntity();
			$currentNews->setAuthor($author);
			$currentNews->setWall($this->wall);
			$this->currentNewsUpdater->updatecurrentNews($currentNews, $this->getData('currentNews'));
			$this->addCurrentNewsData($currentNews);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	public function update($id)
	{
		try {
			$currentNews = $this->currentNewsRepository->getById($id);
			$this->currentNewsUpdater->updateCurrentNews($currentNews, $this->getData('currentNews'));
			$this->addCurrentNewsData($currentNews);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	public function delete($id)
	{
		try {
			$currentNews = $this->currentNewsRepository->getById($id);
			$this->currentNewsRepository->remove($currentNews);
			$this->addCurrentNewsData($currentNews);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}

}
