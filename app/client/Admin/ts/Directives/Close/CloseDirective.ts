namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;
	import IDirectiveLinkFn = angular.IDirectiveLinkFn;
	import IScope = angular.IScope;
	import IAugmentedJQuery = angular.IAugmentedJQuery;
	import IAttributes = angular.IAttributes;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import IWindowService = angular.IWindowService;

	export class CloseDirective extends BaseDirective
	{
		private dialogService: DialogService;
		private $window: IWindowService;

		public constructor(dialogService, $window)
		{
			super();
			this.dialogService = dialogService;
			this.$window = $window;
		}

		public link = (scope: IScope, element: IAugmentedJQuery, attributes: IAttributes) =>
		{
			element.on('click', (event) => {
				var panelElement = angular.element('.side-panel');
				if (panelElement.length && !panelElement.get(0).contains(event.target)) {
					if (this.$window.matchMedia("(max-width: 1200px)").matches) {
						event.preventDefault();
						panelElement.find('.js-close-panel').click();
					} else if (!panelElement.hasClass('compress')) {
						event.preventDefault();
						panelElement.addClass('compress');
					}
					try {
						scope.$apply();
					} catch (err) {} // to prevent duplicate $apply()
				}
			});
		}

	}

	CloseDirective.register(angular, 'close', ['dialogService', '$window']);

}