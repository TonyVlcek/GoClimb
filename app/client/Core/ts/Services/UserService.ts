namespace GoClimb.Admin.Services
{

	import BaseService = GoClimb.Core.Services.BaseService;
	import IWindowService = angular.IWindowService;
	import Utils = GoClimb.Core.Utils.Utils;
	import UserFacade = GoClimb.Core.Model.Facades.UserFacade;
	import IUser = GoClimb.Core.Model.Entities.IUser;

	export class UserService extends BaseService
	{

		private $window: IWindowService;
		private user: IUser = null;
		private links = null;
		private userFacade: UserFacade;

		public constructor($window, user, authLinks, userFacade)
		{
			super();
			this.$window = $window;
			this.user = user;
			this.links = authLinks;
			this.userFacade = userFacade;
		}

		public isLoggedIn(): boolean
		{
			return this.user != null;
		}

		public getUserId()
		{
			return this.user != null ? this.user.id : null;
		}

		public getUser(callback: (user) => void)
		{
			if (!this.isLoggedIn){
				callback(null);
			}

			if (this.user.basic){
			   this.userFacade.getUser(this.user.id, (user) => {
					this.user = user;
					callback(this.user);
			   });
			} else {
				callback(this.user);
			}
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

	UserService.register(angular, 'userService', ['$window', 'user', 'links', 'userFacade']);

}
