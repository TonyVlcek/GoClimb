<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules\AdminModule;

use OnlineClimbing\UI\Forms\User\ISignInFormFactory;


class DashboardPresenter extends BaseAdminPresenter
{

	/** @var ISignInFormFactory @inject */
	public $signInFormFactory;


	protected function createComponentSignInForm()
	{
		$form = $this->signInFormFactory->create();
		$that = $this;
		$form->onSuccess[] = function () use ($that) {
			$that->redirect('this');
		};
		return $form;
	}

}
