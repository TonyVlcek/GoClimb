namespace GoClimb.Core.Model.Facades
{

	import IUser = GoClimb.Core.Model.Entities.IUser;
	import Utils = GoClimb.Core.Utils.Utils;
	import HttpService = GoClimb.Core.Model.Http.HttpService;

	export class UserFacade extends BaseFacade
	{

		constructor(httpService: HttpService, user: IUser)
		{
			super(httpService);
		}

		public getUsers(callback: Function, errorCallback: Function = null)
		{
			this.httpService.requestGet('users/', callback, {}, errorCallback);
		}

		public getUser(id: number, callback: Function, errorCallback: Function = null)
		{
			this.httpService.requestGet('users/' + id, callback, {}, errorCallback);
		}

		public updateUser(user: IUser, callback: (user: IUser) => void = null, errorCallback: Function = null): UserFacade
		{
			user = angular.copy(user);
			user = UserFacade.userToJson(user);
			this.httpService.requestPost('users/' + user.id, {user: user}, (data) => {
				if (callback) {
					callback(UserFacade.mapUser(data.user));
				}
			}, errorCallback);
			return this;
		}

		public getByEmail(email: string, callback: (user) => void = null, errorCallback: Function = null)
		{
			this.httpService.requestGet('users/?email=' + encodeURIComponent(email), (data) => {
				callback(UserFacade.mapUser(data.user));
			}, {}, errorCallback);
		}

		private static mapUser(user: IUser): IUser
		{
			if (user.climbingSince) {
				user.climbingSince = Utils.stringToDate(user.climbingSince);
			}

			if (user.birthDate) {
				user.birthDate = Utils.stringToDate(user.birthDate);
			}

			return user;
		}


		private static userToJson(user: IUser): IUser
		{
			if (user.climbingSince) {
				user.climbingSince = Utils.dateToString(user.climbingSince);
			} else {
				user.climbingSince = null;
			}

			if (user.birthDate) {
				user.birthDate = Utils.dateToString(user.birthDate);
			} else {
				user.birthDate = null;
			}

			return user;
		}
	}

	UserFacade.register(angular, 'userFacade', ['httpService']);

}
