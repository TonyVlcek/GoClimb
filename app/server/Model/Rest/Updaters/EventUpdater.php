<?php

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\Event;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\EventRepository;
use GoClimb\Model\Rest\Utils;
use stdClass;


class EventUpdater
{

	/** @var EventRepository */
	private $eventRepository;


	public function __construct(EventRepository $eventRepository)
	{
		$this->eventRepository = $eventRepository;
	}


	/**
	 * @param Event $event
	 * @param stdClass $data
	 * @throws MappingException
	 * @return Event
	 */
	public function updateEvent(Event $event, stdClass $data = NULL)
	{
		if (!$data) {
			throw MappingException::invalidData();
		}

		Utils::updateProperties($event, $data, [
			'name' => TRUE,
			'content' => TRUE,
		]);

		$event->setStartDate(Utils::toDateTime($data->startDate));
		if ($data->endDate) {
			$event->setEndDate(Utils::toDateTime($data->endDate));
		}

		if (isset($data->published) && !$event->isPublished() && $data->published) {
			$event->publish();
		}

		$this->eventRepository->save($event);

		return $event;
	}

}
