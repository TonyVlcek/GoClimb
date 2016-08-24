namespace GoClimb.Admin.Model.Facades
{

	export class UserFacade extends BaseFacade
	{

		public getUsers(callback: Function, errorCallback: Function = null)
		{
			this.httpService.get('users/default/', callback, errorCallback);
		}

		public getUser(id: number, callback: Function, errorCallback: Function = null)
		{
			var url: string = 'users/default/' + id;
			this.httpService.get(url, callback, errorCallback);
		}

	}

	UserFacade.register(angular, 'userFacade', ['httpService']);

}
