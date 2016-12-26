<?php

namespace GoClimb\Modules\WallModule\FrontModule;

use GoClimb\Model\Facades\RestFacade;
use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\Rest\Mappers\UserMapper;


class DashboardPresenter extends BaseFrontPresenter
{


	/** @var RestFacade */
	private $restFacade;

	/** @var UserFacade */
	private $userFacade;


	public function __construct(RestFacade $restFacade, UserFacade $userFacade)
	{
		parent::__construct();
		$this->restFacade = $restFacade;
		$this->userFacade = $userFacade;
	}


	public function renderDefault()
	{
		$languages = [];
		foreach ($this->wall->getWallLanguages() as $wallLanguage) {
			$shortcut = $wallLanguage->getLanguage()->getShortcut();
			$languages[$shortcut] = $this->link('//this', ['path' => '__PATH__', 'locale' => $shortcut]);
		}

		$user = NULL;
		if ($this->user->isLoggedIn()) {
			$user = UserMapper::mapBasicInfo($this->userFacade->getById($this->user->getId()));
		}

		$loginBacklink = $this->link('//this', [$this::LOGIN_PARAMETER => $this::TOKEN_PLACEHOLDER]);
		$logoutBacklink = $this->link('//this', [$this::LOGOUT_PARAMETER => 1]);

		$this->template->data = [
			'availableLanguages' => $languages,
			'restToken' => $this->user->isLoggedIn() ? $this->restFacade->getOrGenerateRestToken($this->wall, $this->user->getUserEntity(), $this->getHttpRequest()->getRemoteAddress())->getToken() : NULL,
			'cdnUrl' => $this->cdnLinkGenerator->getCdnUrl(),
			'apiUrl' => $this->link('//:Wall:Rest:V1:Dashboard:default'),
			'permissions' => $this->getPermissions(),
			'links' => [
				'logs' => $this->link('//:App:Dashboard:default'),
				'login' => $this->getLoginLink($this->getApplicationToken(), $loginBacklink),
				'logout' => $this->getLogoutLink($this->getApplicationToken(), $logoutBacklink),
				'register' => $this->getRegisterLink($this->getApplicationToken(), $loginBacklink),
			],
			'user' => $user,
			'wall' => $this->wall->getName(),
		];

		$this->initMenu();

		$this->template->locale = $this->locale;
	}
}
