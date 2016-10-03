namespace GoClimb.Core.Model.Facades
{

	import HttpService = GoClimb.Core.Model.Http.HttpService;
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
