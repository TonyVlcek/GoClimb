namespace GoClimb.Admin.Model.Facades
{

	export class WallDetailsFacade extends BaseFacade
	{

		public getDetails(callback: Function, errorCallback: Function = null)
		{
			this.httpService.get('details/', callback, errorCallback);
		}

		public updateDetails(details, callback: Function, errorCallback: Function = null)
		{
			this.httpService.post('details/', {details: details}, callback, errorCallback);
		}

	}

	WallDetailsFacade.register(angular, 'wallDetailsFacade', ['httpService']);

}
