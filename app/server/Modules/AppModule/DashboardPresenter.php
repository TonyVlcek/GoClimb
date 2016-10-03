<?php

namespace GoClimb\Modules\AppModule;

use GoClimb\Model\Repositories\UserRepository;


class DashboardPresenter extends BaseAppPresenter
{

	/** @var UserRepository */
	public $userRepository;


	public function __construct(UserRepository $userRepository)
	{
		parent::__construct();
		$this->userRepository = $userRepository;
	}


	public function startup()
	{
		parent::startup();

		$user = $this->userRepository->getById($this->user->getIdentity()->getId());
		$this->template->userEmail = $user->getEmail();
	}

	public function actionDefault()
	{
		$this->template->logs = [];
	}
}
