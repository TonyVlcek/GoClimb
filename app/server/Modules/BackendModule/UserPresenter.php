<?php

namespace GoClimb\Modules\BackendModule;

use GoClimb\Model\Entities\User;
use GoClimb\UI\Forms\User\IUserFormFactory;
use GoClimb\UI\Grids\User\IUserGridFactory;


class UserPresenter extends BaseBackendPresenter
{

	/** @var  IUserFormFactory */
	private $userFormFactory;

	/** @var IUserGridFactory */
	private $userGridFactory;

	/** @var  User */
	private $user;


	public function __construct(IUserGridFactory $userGridFactory, IUserFormFactory $userFormFactory)
	{
		parent::__construct();
		$this->userGridFactory = $userGridFactory;
		$this->userFormFactory = $userFormFactory;
	}


	public function actionCreate()
	{
		$this->user = new User;
	}


	public function actionEdit(User $user)
	{
		$this->user = $user;
	}


	protected function createComponentUserForm()
	{
		$form = $this->userFormFactory->create($this->user);

		$form->onCreate[] = function () {
			$this->flashMessageSuccess('user.created');
			$this->redirect('default');
		};

		$form->onEdit[] = function () {
			$this->flashMessageSuccess('user.edited');
			$this->redirect('default');
		};

		return $form;
	}


	protected function createComponentUserGrid()
	{
		return $this->userGridFactory->create();
	}

}
