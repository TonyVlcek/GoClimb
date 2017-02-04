namespace GoClimb.Core.Model.Facades
{

	import HttpService = GoClimb.Core.Model.Http.HttpService;
	import Utils = GoClimb.Core.Utils.Utils;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import IArticle = GoClimb.Core.Model.Entities.IArticle;

	export class LabelsFacade extends BaseFacade
	{

		private apiUrl: string;
		private restToken: string;

		public constructor(httpService: HttpService, apiUrl: string, restToken: string)
		{
			super(httpService);
			this.httpService = httpService;
			this.apiUrl = apiUrl;
			this.restToken = restToken;
		}

		public generateLabels(ids: [number])
		{
			return this.apiUrl + 'labels/' + ids.toString() + '?token=' + this.restToken;
			// window.open(url);
		}

	}

	LabelsFacade.register(angular, 'labelsFacade', ['httpService', 'apiUrl', 'restToken']);

}
