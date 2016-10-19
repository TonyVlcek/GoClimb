namespace GoClimb.Core.Model.Facades
{

	export class UserFacade extends BaseFacade
	{

		public getUsers(callback: Function, errorCallback: Function = null)
		{
			this.httpService.requestGet('users/', callback, {}, errorCallback);
		}

		public getUser(id: number, callback: Function, errorCallback: Function = null)
		{
			this.httpService.requestGet('users' + id, callback, {}, errorCallback);
		}

		public getByEmail(email: string, callback: (user) => void = null, errorCallback: Function = null)
		{
			this.httpService.requestGet('users/?email=' + encodeURIComponent(email), (data) => {
				callback(data.user);
			}, {}, errorCallback);
		}
	}

	UserFacade.register(angular, 'userFacade', ['httpService']);

}
