namespace GoClimb.Admin.Model.Facades
{

	export class UserFacade extends BaseFacade
	{

		public getUsers(callback: Function, errorCallback: Function = null)
		{
			this.httpService.requestGet('users/default/', callback, errorCallback);
		}

		public getUser(id: number, callback: Function, errorCallback: Function = null)
		{
			var url: string = 'users/default/' + id;
			this.httpService.requestGet(url, callback, errorCallback);
		}

		public getByEmail(email: string, callback: (user) => void = null, errorCallback: Function = null)
		{
			this.httpService.requestGet('users', (data) => {
				callback(data.user);
			}, {email: email}, errorCallback);
		}
	}

	UserFacade.register(angular, 'userFacade', ['httpService']);

}
