namespace GoClimb.App.Controllers
{

	import BaseController = GoClimb.Core.Controllers.BaseController;
	import ILog = GoClimb.Core.Model.Entities.ILog;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import LogsFacade = GoClimb.Core.Model.Facades.LogsFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import DialogService = GoClimb.Admin.Services.DialogService;

	export class DashboardController extends BaseController
	{

		public processingDelete: number = null;

		private logs: IndexedArray<ILog> = null;
		private loading: boolean = false;

		private flashMessageSender: FlashMessageSender;
		private dialogService: DialogService;
		private logsFacade: LogsFacade;


		public constructor(flashMessageSender: FlashMessageSender, dialogService: DialogService, logsFacade: LogsFacade)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.dialogService = dialogService;
			this.logsFacade = logsFacade;
		}


		public getLogs(): IndexedArray<ILog>
		{
			if (!this.loading && !this.logs) {
				this.loading = true;
				this.logsFacade.getLogs((logs) => {
					this.loading = false;
					this.logs = logs;
				});
			}
			return this.logs;
		}

	}

	DashboardController.register(angular, 'DashboardController', ['flashMessageSender', 'dialogService', 'logsFacade']);

}
