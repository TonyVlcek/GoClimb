<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\RestModule\V1Module;

use GoClimb\Model\Entities\Log;
use GoClimb\Model\MappingException;
use GoClimb\Model\Facades\LogsFacade;
use GoClimb\Model\Repositories\LogRepository;
use GoClimb\Model\Rest\Mappers\LogMapper;
use GoClimb\Model\Rest\Updaters\LogUpdater;


class LogsPresenter extends BaseV1Presenter
{

	/** @var LogRepository */
	private $logRepository;

	/** @var LogsFacade */
	private $logsFacade;

	/** @var LogUpdater */
	private $logUpdater;

	public function __construct(LogRepository $logRepository, LogsFacade $logsFacade, LogUpdater $logUpdater)
	{
		parent::__construct();
		$this->logRepository = $logRepository;
		$this->logsFacade = $logsFacade;
		$this->logUpdater = $logUpdater;
	}


	public function actionGet($id = NULL)
	{
		if ($id === NULL) {
			$this->addLogsData($this->logsFacade->getLogsByUserId($this->getUser()->id));
		} elseif (!$log = $this->logRepository->getById($id)) {
			$this->sendNotFound();
		} elseif ($log->getUser()->getId() !== $this->getUser()->id){
			$this->sendForbidden();
		} else {
			$this->addLogData($log);
		}
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

			if($log->getUser() !== $this->getUser()->getUserEntity()){
				$this->sendForbidden();
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

	private function addLogsData($logs)
	{
		$this->addData('logs', LogMapper::mapArray($logs));
	}


	private function checkPermissions()
	{
		if (!$this->user->isLoggedIn()) {
			$this->sendForbidden();
		}
	}

}
