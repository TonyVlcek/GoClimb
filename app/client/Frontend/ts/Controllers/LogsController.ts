namespace GoClimb.Admin.Controllers
{
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import BaseController = GoClimb.Core.Controllers.BaseController;


	export class LogsController extends BaseController
	{

		public user = null;
		public links = null;

		public constructor(user, authLinks)
		{
			super();
			this.user = user;
			this.links = authLinks;
		}

	}

	LogsController.register(angular, 'LogsController', ['user', 'links']);

}
