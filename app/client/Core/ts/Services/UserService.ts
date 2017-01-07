namespace GoClimb.Admin.Services
{

	import BaseService = GoClimb.Core.Services.BaseService;
	import IWindowService = angular.IWindowService;
	import Utils = GoClimb.Core.Utils.Utils;

	export class UserService extends BaseService
	{

		private $window: IWindowService;
		private user = null;
		private links = null;

		public constructor($window, user, authLinks)
		{
			super();
			this.$window = $window;
			this.user = user;
			this.links = authLinks;
		}

		public isLoggedIn(): boolean
		{
			return this.user != null;
		}

		public requireLogin()
		{
			if (this.user == null) {
				var url: string = this.links.login;
				var backUrl = decodeURI(Utils.getQueryVariable(url, 'back'));
				var loginToken = Utils.getQueryVariable(backUrl, 'loginToken');
				url = url.substring(0, url.indexOf('back='));

				backUrl = this.$window.location.href;
				url = url + 'back=' + encodeURIComponent(backUrl + "?loginToken=" + loginToken);
				this.$window.location.href = url;
			}
		}

	}

	UserService.register(angular, 'userService', ['$window', 'user', 'links']);

}
