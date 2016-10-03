<?php

namespace GoClimb\Modules\WallModule\FrontModule;

use GoClimb\Model\Facades\RestFacade;
use GoClimb\Model\Facades\UserFacade;


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
			$user = $this->userFacade->getById($this->user->getId());
			if ($user->getFullName()) {
				$name = $user->getFullName();
			} elseif ($user->getNick()) {
				$name = $user->getNick();
			} else {
				$name = $user->getEmail();
			}

			$user = [
				'id' => $user->getId(),
				'name' => $name,
			];
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
		];

		$this->template->locale = $this->locale;
	}
}
