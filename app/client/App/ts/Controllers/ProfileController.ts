namespace GoClimb.App.Controllers
{

	import BaseController = GoClimb.Core.Controllers.BaseController;
	import ILog = GoClimb.Core.Model.Entities.ILog;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import LogsFacade = GoClimb.Core.Model.Facades.LogsFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import IUser = GoClimb.Core.Model.Entities.IUser;
	import UserService = GoClimb.Admin.Services.UserService;

	export class ProfileController extends BaseController
	{
		private user: IUser;
		private flashMessageSender: FlashMessageSender;
		private dialogService: DialogService;
		private userService: UserService;


		public constructor(flashMessageSender: FlashMessageSender, dialogService: DialogService, userService: UserService)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.dialogService = dialogService;
			this.userService = userService;
		}

		public getUser()
		{
			this.userService.getUser((user) => {
				this.user = user;
			});

			return this.user;
		}
	}

	ProfileController.register(angular, 'ProfileController', ['flashMessageSender', 'dialogService', 'userService']);

}
