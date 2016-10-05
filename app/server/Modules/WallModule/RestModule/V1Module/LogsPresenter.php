<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\Log;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\LogRepository;
use GoClimb\Model\Rest\Mappers\LogMapper;
use GoClimb\Model\Rest\Updaters\LogUpdater;


class LogsPresenter extends BaseV1Presenter
{


	/** @var LogRepository */
	private $logRepository;

	/** @var LogUpdater */
	private $logUpdater;


	public function __construct(LogRepository $logRepository, LogUpdater $logUpdater)
	{
		parent::__construct();
		$this->logRepository = $logRepository;
		$this->logUpdater = $logUpdater;
	}


	public function actionPost($id = NULL)
	{
		$this->checkPermissions();
		try {
			if ($id === NULL) {
				$log = new Log;
				$log->setUser($this->getUser()->getUserEntity());
			} else {
				if (!$log = $this->logRepository->getById($id)) {
					$this->sendNotFound();
				}
			}
			$this->logUpdater->updateLog($log, $this->getData('log'));
			$this->addLogData($log);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	private function addLogData($log)
	{
		$this->addData('log', LogMapper::map($log));
	}


	private function checkPermissions()
	{
		if (!$this->user->isLoggedIn()) {
			$this->sendForbidden();
		}
	}

}
