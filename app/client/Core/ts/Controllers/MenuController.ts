namespace GoClimb.Core.Controllers
{

	import WallDetailsFacade = GoClimb.Core.Model.Facades.WallDetailsFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;

	export class MenuController extends BaseController
	{

		public menu;

		public constructor(menu)
		{
			super();
			this.menu = menu;
		}


	}

	MenuController.register(angular, 'MenuController', ['menu']);

}
