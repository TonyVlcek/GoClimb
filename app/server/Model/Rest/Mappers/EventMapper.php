<?php

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Event;
use GoClimb\Model\Rest\Utils;
use Nette\Utils\DateTime;


class EventMapper
{

	/**
	 * @param Event[] $events
	 * @return array
	 */
	public static function mapArray(array $events)
	{
		$result = [];
		foreach ($events as $key => $event) {
			$result[$event->getId()] = self::map($event);
		}

		return $result;
	}


	/**
	 * @param Event $event
	 * @return array
	 */
	public static function map(Event $event)
	{
		return [
			'id' => $event->getId(),
			'name' => $event->getName(),
			'content' => $event->getContent(),
			'author' => [
				'id' => $event->getAuthor()->getId(),
				'name' => $event->getAuthor()->getFullName(),
			],
			'startDate' => Utils::formatDateTime($event->getStartDate()),
			'endDate' => Utils::formatDateTime($event->getEndDate()),
			'publishedDate' => Utils::formatDateTime($event->getPublishedDate()),
			'published' => $event->isPublished(),
		];
	}
}
