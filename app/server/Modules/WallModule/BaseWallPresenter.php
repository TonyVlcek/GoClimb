<?php

namespace GoClimb\Modules\WallModule;

use GoClimb\Model\Entities\AclRole;
use GoClimb\Model\Entities\Wall;
use GoClimb\Modules\BasePresenter;
use Nette\Application\Request;


abstract class BaseWallPresenter extends BasePresenter
{

	/** @var Wall @persistent */
	public $wall;


	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsWallSite($request->getParameter('wall'));
	}


	public function beforeRender()
	{
		parent::beforeRender();
		$languages = [];
		foreach ($this->wall->getWallLanguages() as $wallLanguage) {
			$shortcut = $wallLanguage->getLanguage()->getShortcut();
			$languages[$shortcut] = $this->link('//this', ['path' => '__PATH__', 'locale' => $shortcut]);
		}
		$this->template->availableLanguages = $languages;
	}


	/**
	 * @inheritdoc
	 */
	protected function getApplicationToken()
	{
		return $this->wall->getApplication()->getToken();
	}


	/**
	 * @return string[]
	 */
	protected function getPermissions()
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
		if ($role->getWall() !== $this->wall) {
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
