<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules\BackendModule;

use OnlineClimbing\UI\Grids\User\IUserGridFactory;


class UserPresenter extends BaseBackendPresenter
{

	/** @var IUserGridFactory */
	private $userGridFactory;


	public function __construct(IUserGridFactory $userGridFactory)
	{
		parent::__construct();
		$this->userGridFactory = $userGridFactory;
	}


	protected function createComponentUserGrid()
	{
		return $this->userGridFactory->create();
	}

}
