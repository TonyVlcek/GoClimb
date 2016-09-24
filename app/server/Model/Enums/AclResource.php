<?php

namespace GoClimb\Model\Enums;


class AclResource
{

	const BACKEND_DASHBOARD = 'backend_dashboard';

	const ADMIN_DASHBOARD = 'admin.dashboard';
	const ADMIN_SETTINGS_ADVANCED = 'admin.settings.advanced';
	const ADMIN_ARTICLES = 'admin.articles';
	const ADMIN_EVENTS = 'admin.events';
	const ADMIN_NEWS = 'admin.news';
	const ADMIN_ACL = 'admin.acl';
	const ADMIN_ROUTES_ROPE = 'admin.routes.rope';
	const ADMIN_ROUTES_BOULDER = 'admin.routes.boulder';


	public static function isValid($resource)
	{
		return in_array($resource, self::getAll(), TRUE);
	}


	public static function getAll()
	{
		return array_merge(self::getBackend(), self::getAdmin());
	}


	public static function getBackend()
	{
		return [
			self::BACKEND_DASHBOARD,
		];
	}


	public static function getAdmin()
	{
		return [
			self::ADMIN_DASHBOARD,
			self::ADMIN_SETTINGS_ADVANCED,
			self::ADMIN_ARTICLES,
			self::ADMIN_EVENTS,
			self::ADMIN_NEWS,
			self::ADMIN_ACL,
			self::ADMIN_ROUTES_ROPE,
			self::ADMIN_ROUTES_BOULDER,
		];
	}

}
