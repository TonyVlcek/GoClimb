namespace GoClimb.Admin.Model.Facades
{

	import HttpService = GoClimb.Admin.Model.Http.HttpService;
	import BaseService = GoClimb.Core.Services.BaseService;

	export abstract class BaseFacade extends BaseService
	{

		protected httpService: HttpService;

		public constructor(httpService: HttpService)
		{
			super();
			this.httpService = httpService;
		}

	}

}
