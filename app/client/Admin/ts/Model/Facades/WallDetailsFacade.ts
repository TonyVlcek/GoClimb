namespace GoClimb.Admin.Model.Facades
{

	export class WallDetailsFacade extends BaseFacade
	{

		public getDetails(callback: Function, errorCallback: Function = null)
		{
			this.httpService.requestGet('details/', callback, errorCallback);
		}

		public updateDetails(details, callback: Function, errorCallback: Function = null)
		{
			this.httpService.requestPost('details/', {details: details}, callback, errorCallback);
		}

	}

	WallDetailsFacade.register(angular, 'wallDetailsFacade', ['httpService']);

}
