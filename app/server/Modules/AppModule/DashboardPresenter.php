<?php

namespace GoClimb\Modules\AppModule;

use GoClimb\Model\Entities\AclRole;
use GoClimb\Model\Facades\RestFacade;
use GoClimb\Model\Repositories\LanguageRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Model\Rest\Mappers\UserMapper;


class DashboardPresenter extends BaseAppPresenter
{

	/** @var WallRepository */
	private $wallRepository;

	/** @var RestFacade */
	private $restFacade;

	/** @var LanguageRepository */
	private $languageRepository;


	public function __construct(WallRepository $wallRepository, RestFacade $restFacade, LanguageRepository $languageRepository)
	{
		parent::__construct();
		$this->wallRepository = $wallRepository;
		$this->restFacade = $restFacade;
		$this->languageRepository = $languageRepository;
	}


	public function renderDefault()
	{
		$this->template->walls = $this->wallRepository->getAll();
		$languages = [];
		foreach ($this->languageRepository->getAll() as $language) {
			$shortcut = $language->getShortcut();
			$languages[$shortcut] = $this->link('//this', ['path' => '__PATH__', 'locale' => $shortcut]);
		}

		$this->template->data = [
			'availableLanguages' => $languages,
			'apiUrl' => $this->link('//:Rest:V1:Dashboard:default'),
			'restToken' => $this->user->isLoggedIn() ? $this->restFacade->getOrGenerateGlobalRestToken($this->user->getUserEntity(), $this->getHttpRequest()->getRemoteAddress())->getToken() : NULL,
			'cdnUrl' => $this->cdnLinkGenerator->getCdnUrl(),
			'permissions' => $this->getPermissions(),
			'user' => $this->user->isLoggedIn() ? UserMapper::map($this->user->getUserEntity()) : NULL,
			'links' => [],
		];

		$this->initMenu();
		$this->template->locale = $this->locale;
	}


	/**
	 * @return string[]
	 */
	private function getPermissions()
	{
		if (!$this->user->isLoggedIn()) {
			return [];
		}
		$result = [];
		foreach ($this->user->getUserEntity()->getRoles() as $role) {
			$result = array_merge($result, $this->getRolePermissions($role));
		}
		return array_unique($result);
	}


	/**
	 * @param AclRole $role
	 * @return string[]
	 */
	private function getRolePermissions(AclRole $role)
	{
		if ($role->getWall() !== NULL) {
			return [];
		}
		$permissions = [];
		foreach ($role->getPermissions() as $permission) {
			if ($permission->isAllowed()) {
				$permissions[] = $permission->getResource()->getName();
			}
		}
		if ($role->getParent()) {
			$permissions = array_merge($permissions, $this->getRolePermissions($role->getParent()));
		}
		return $permissions;
	}

}
