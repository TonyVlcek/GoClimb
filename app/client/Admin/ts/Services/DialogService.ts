namespace GoClimb.Admin.Services
{
	import BaseService = GoClimb.Core.Services.BaseService;
	import ITranslateService = angular.translate.ITranslateService;

	export class DialogService extends BaseService
	{
		private $window: ng.IWindowService;
		private $translate: ITranslateService;

		public constructor($window, $translate: ITranslateService)
		{
			super();
			this.$window = $window;
			this.$translate = $translate;
		}

		public confirm(message: string/*, buttonYes : string = null, buttonNo : string = null*/): boolean
		{
			message = this.$translate.instant(message);
			return this.$window.confirm(message);
		}

		public alert(message: string/*, buttonYes : string = null*/): void
		{
			message = this.$translate.instant(message);
			this.$window.alert(message);
		}
	}

	DialogService.register(angular, 'DialogService', ['$window', '$translate'])
}
