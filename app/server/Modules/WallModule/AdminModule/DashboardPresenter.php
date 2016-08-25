<?php

namespace GoClimb\Modules\WallModule\AdminModule;

use GoClimb\Model\Facades\RestFacade;


class DashboardPresenter extends BaseAdminPresenter
{


	/** @var RestFacade */
	private $restFacade;


	public function __construct(RestFacade $restFacade)
	{
		parent::__construct();
		$this->restFacade = $restFacade;
	}


	public function actionDefault()
	{
		if (!$this->user->isLoggedIn()) {
			$this->redirectUrl($this->getLoginLink($this->getApplicationToken(), $this->link('//this', [$this::LOGIN_PARAMETER => $this::TOKEN_PLACEHOLDER])));
		}
	}


	public function renderDefault()
	{
		$this->template->cdnUrl = $this->cdnLinkGenerator->getCdnUrl();
		$this->template->restToken = $this->user->isLoggedIn() ? $this->restFacade->getOrGenerateRestToken($this->wall, $this->user->getUserEntity(), $this->getHttpRequest()->getRemoteAddress())->getToken() : NULL;
		$this->template->locale = $this->locale;
	}

}
