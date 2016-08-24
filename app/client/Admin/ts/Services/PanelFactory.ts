namespace GoClimb.Admin.Services
{


	import BaseService = GoClimb.Core.Services.BaseService;
	import IApi = Foundation.IApi;
	import ITimeoutService = angular.ITimeoutService;
	import IWindowService = angular.IWindowService;

	export class PanelFactory extends BaseService
	{

		private api: IApi;
		private $timeout;
		private $window: ng.IWindowService;
		private dialogService;


		public constructor($timeout: ITimeoutService, $window: IWindowService, api: IApi, dialogService: DialogService)
		{
			super();
			this.api = api;
			this.$timeout = $timeout;
			this.$window = $window;
			this.dialogService = dialogService;
		}

		public create(panelId: string, alwaysAnimateOpen: boolean, size: PanelSize): Panel
		{
			var panel = new Panel(
				this.$timeout,
				this.$window,
				this.api,
				this.dialogService,
				panelId,
				alwaysAnimateOpen,
				size
			);

			return panel;
		}
	}

	PanelFactory.register(angular, 'panelFactory', ['$timeout', '$window', 'FoundationApi', 'DialogService']);
}
