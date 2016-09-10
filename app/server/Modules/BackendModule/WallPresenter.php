<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\BackendModule;

use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\UI\Forms\Wall\IWallFormFactory;
use GoClimb\UI\Grids\Wall\IWallGridFactory;


class WallPresenter extends BaseBackendPresenter
{


	/** @var WallRepository */
	private $wallRepository;

	/** @var IWallFormFactory */
	private $wallFormFactory;

	/** @var IWallGridFactory */
	private $wallGridFactory;

	/** @var Wall[] */
	private $walls;


	public function __construct(WallRepository $wallRepository, IWallGridFactory $wallGridFactory, IWallFormFactory $wallFormFactory)
	{
		parent::__construct();
		$this->wallRepository = $wallRepository;
		$this->wallFormFactory = $wallFormFactory;
		$this->wallGridFactory = $wallGridFactory;
	}


	public function createComponentWallForm()
	{
		$form = $this->wallFormFactory->create(new Wall);
		$form->onSuccess[] = function () {
			$this->flashMessageSuccess('wall.created');
			$this->redirect('default');
		};
		return $form;
	}


	protected function createComponentWallGrid()
	{
		return $this->wallGridFactory->create();
	}


	public function actionDefault()
	{
		$this->walls = $this->wallRepository->getAll();
	}


	public function renderDefault()
	{
		$this->template->walls = $this->walls;
	}

}
