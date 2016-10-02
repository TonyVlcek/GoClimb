<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Sector;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Repositories\LineRepository;
use GoClimb\Model\Repositories\SectorRepository;
use GoClimb\Model\Rest\Mappers\LineMapper;
use GoClimb\Model\Rest\Mappers\SectorMapper;


class SectorsPresenter extends BaseV1Presenter
{

	/** @var SectorRepository */
	private $sectorRepository;

	/** @var LineRepository */
	private $lineRepository;


	public function __construct(SectorRepository $sectorRepository, LineRepository $lineRepository)
	{
		parent::__construct();
		$this->sectorRepository = $sectorRepository;
		$this->lineRepository = $lineRepository;
	}


	public function actionGet($id = NULL, $otherAction = NULL)
	{
		$this->checkPermissions();
		if ($otherAction) {
			if (!$id || $otherAction !== 'lines') {
				$this->sendNotFound();
			}
			$this->addLinesData($this->getSector($id)->getLines());
		} elseif ($id) {
			$this->addSectorData($this->getSector($id));
		} else {
			$this->addSectorsData($this->sectorRepository->getByWall($this->wall));
		}
	}


	public function actionPost($id = NULL, $otherAction = NULL)
	{
		$this->checkPermissions();
		if ($otherAction) {
			if (!$id || $otherAction !== 'lines') {
				$this->sendNotFound();
			}
			$sector = $this->getSector($id);
			$line = $this->lineRepository->create($sector, $this->getData('line')->name);
			$this->addLineData($line);
		} elseif ($id) {
			$this->sendMethodNotAllowed();
		} else {
			$sector = $this->sectorRepository->create($this->wall, $this->getData('sector')->name);
			$this->addSectorData($sector);
		}
	}


	private function addSectorsData(array $sectors)
	{
		$this->addData('sectors', SectorMapper::mapArray($sectors));
	}


	private function addSectorData(Sector $sector)
	{
		$this->addData('sector', SectorMapper::map($sector));
	}


	private function addLinesData(array $lines)
	{
		$this->addData('lines', LineMapper::mapArray($lines));
	}


	private function addLineData(Line $line)
	{
		$this->addData('line', LineMapper::map($line));
	}


	/**
	 * @param int $id
	 * @return Sector
	 */
	private function getSector($id)
	{
		if (!($sector = $this->sectorRepository->getById($id)) || $sector->getWall() !== $this->wall) {
			$this->sendNotFound();
		}
		return $sector;
	}


	private function checkPermissions()
	{
		if (!($this->user->isAllowed(AclResource::ADMIN_ROUTES_BOULDER) || $this->user->isAllowed(AclResource::ADMIN_ROUTES_ROPE))) {
			$this->sendForbidden();
		}
	}

}
