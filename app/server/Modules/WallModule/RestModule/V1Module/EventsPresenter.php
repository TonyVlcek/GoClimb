<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\Article;
use GoClimb\Model\Entities\Event;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\ArticleRepository;
use GoClimb\Model\Repositories\EventRepository;
use GoClimb\Model\Rest\Mappers\ArticleMapper;
use GoClimb\Model\Rest\Mappers\EventMapper;
use GoClimb\Model\Rest\Updaters\ArticleUpdater;
use GoClimb\Model\Rest\Updaters\EventUpdater;


class EventsPresenter extends BaseV1Presenter
{

	/** @var EventRepository */
	private $eventRepository;

	/** @var EventUpdater */
	private $eventUpdater;

	/** @var UserFacade */
	private $userFacade;


	public function __construct(EventRepository $eventRepository, EventUpdater $eventUpdater, UserFacade $userFacade)
	{
		parent::__construct();
		$this->eventRepository = $eventRepository;
		$this->eventUpdater = $eventUpdater;
		$this->userFacade = $userFacade;
	}


	public function actionGet($id = NULL)
	{
		$this->checkPermissions();
		if ($id === NULL) {
			$this->addEventsData();
		} elseif (!$event = $this->eventRepository->getById($id)) {
			$this->sendNotFound();
		} else {
			$this->addEventData($event);
		}
	}


	public function actionPost($id = NULL)
	{
		$this->checkPermissions();
		try {
			if ($id === NULL) {
				$event = new Event;
				$author = $this->getUser()->getUserEntity();
				$event->setAuthor($author);
				$event->setWall($this->wall);
			} else {
				if (!$event = $this->eventRepository->getById($id)) {
					$this->sendNotFound();
				}
			}
			$this->eventUpdater->updateEvent($event, $this->getData('event'));
			$this->addEventData($event);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	public function actionDelete($id = NULL)
	{
		$this->checkPermissions();
		try {
			if (!$id || !$event = $this->eventRepository->getById($id)) {
				$this->sendNotFound();
			} else {
				$this->eventRepository->remove($event);
				$this->addEventData($event);
			}
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	private function addEventsData()
	{
		$events = $this->eventRepository->getByWall($this->wall);
		$this->addData('events', EventMapper::mapArray($events));
	}


	private function addEventData(Event $event)
	{
		$this->addData('event', EventMapper::map($event));
	}


	private function checkPermissions()
	{
		if (!$this->user->isAllowed(AclResource::ADMIN_EVENTS)) {
			$this->sendForbidden();
		}
	}

}
