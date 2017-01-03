namespace GoClimb.App.Controllers
{

	import BaseController = GoClimb.Core.Controllers.BaseController;
	import ILog = GoClimb.Core.Model.Entities.ILog;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import LogsFacade = GoClimb.Core.Model.Facades.LogsFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import UserFacade = GoClimb.Core.Model.Facades.UserFacade;
	import IUser = GoClimb.Core.Model.Entities.IUser;

	export class ProfileController extends BaseController
	{
		private user: IUser;
		private flashMessageSender: FlashMessageSender;
		private dialogService: DialogService;
		private userFacade: UserFacade;


		public constructor(flashMessageSender: FlashMessageSender, dialogService: DialogService, userFacade: UserFacade)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.dialogService = dialogService;
			this.userFacade = userFacade;
		}

		public getUser()
		{
			this.userFacade.getLoggedUser((user) => {
				this.user = user;
			});

			return this.user;
		}
	}

	ProfileController.register(angular, 'ProfileController', ['flashMessageSender', 'dialogService', 'userFacade']);

}
