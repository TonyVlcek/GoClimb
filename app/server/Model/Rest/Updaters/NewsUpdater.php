<?php

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\News;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\NewsRepository;
use GoClimb\Model\Rest\Utils;
use stdClass;


class NewsUpdater
{

	/** @var NewsRepository */
	private $newsRepository;


	public function __construct(NewsRepository $newsRepository)
	{
		$this->newsRepository = $newsRepository;
	}


	/**
	 * @param News $news
	 * @param stdClass $data
	 * @throws MappingException
	 * @return News
	 */
	public function updateNews(News $news, stdClass $data = NULL)
	{
		if (!$data) {
			throw MappingException::invalidData();
		}

		Utils::updateProperties($news, $data, [
			'name' => TRUE
		]);

		if (isset($data->published) && !$news->isPublished() && $data->published) {
			$news->publish();
		}

		$this->newsRepository->save($news);

		return $news;
	}

}
