<?php

namespace GoClimb\Modules\WallModule\AdminModule;

use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Facades\RestFacade;
use GoClimb\Model\Rest\Mappers\UserMapper;


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
		foreach (AclResource::getAdmin() as $resource) {
			if ($this->user->isAllowed($resource)) {
				return;
			}
		}
		$this->template->setFile(__DIR__ . '/templates/Error/forbidden.latte');
		$this->template->logoutLink = $this->getLogoutLink($this->getApplicationToken(), $this->link('//this', [$this::LOGOUT_PARAMETER => 1]));
		$this->sendTemplate();
	}


	public function renderDefault()
	{
		$languages = [];
		foreach ($this->wall->getWallLanguages() as $wallLanguage) {
			$shortcut = $wallLanguage->getLanguage()->getShortcut();
			$languages[$shortcut] = $this->link('//this', ['path' => '__PATH__', 'locale' => $shortcut]);
		}
		$this->template->data = [
			'availableLanguages' => $languages,
			'apiUrl' => $this->link('//:Wall:Rest:V1:Dashboard:default'),
			'restToken' => $this->user->isLoggedIn() ? $this->restFacade->getOrGenerateRestToken($this->wall, $this->user->getUserEntity(), $this->getHttpRequest()->getRemoteAddress())->getToken() : NULL,
			'cdnUrl' => $this->cdnLinkGenerator->getCdnUrl(),
			'permissions' => $this->getPermissions(),
			'user' => $this->user->isLoggedIn() ? UserMapper::mapBasicInfo($this->user->getUserEntity()) : NULL,
			'links' => [
				'frontend' => $this->link('//:Wall:Front:Dashboard:default'),
			]
		];
		$this->initMenu();
		$this->template->locale = $this->locale;
	}


}
