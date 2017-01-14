namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;
	import IDirectiveLinkFn = angular.IDirectiveLinkFn;
	import IScope = angular.IScope;
	import IAugmentedJQuery = angular.IAugmentedJQuery;
	import IAttributes = angular.IAttributes;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import IWindowService = angular.IWindowService;
	import IApi = Foundation.IApi;

	export class CloseDirective extends BaseDirective
	{
		private dialogService: DialogService;
		private $window: IWindowService;
		private foundationApi: IApi;

		private enums = {
			SHIFT: 16,
			ESC: 27
		};

		public constructor(dialogService, $window, foundationApi: IApi)
		{
			super();
			this.dialogService = dialogService;
			this.$window = $window;
			this.foundationApi = foundationApi;
		}

		public link = (scope: IScope, element: IAugmentedJQuery, attributes: IAttributes) =>
		{
			element.on('click', (event) => {
				this.resolveClick(event, scope);
			});

			var firstPress = false;

			element.on('keyup', (event) => {
				if (event.keyCode == this.enums.SHIFT){
					if(firstPress) {
						this.foundationApi.publish('action-modal', 'open');
						$('.action-modal input[name="searchQuery"]').focus();
						firstPress = false;
					} else {
						firstPress = true;
						this.$window.setTimeout(function() { firstPress = false; }, 500);
					}

				}

				if (event.keyCode == this.enums.ESC) {
					var modal = $('.is-active[zf-closable]#action-modal');
					if (modal.length) {
						this.foundationApi.publish('action-modal', 'close');
					} else {
						this.resolveClick(event, scope, true);
					}
				}
			});

		}

		private resolveClick(event, scope, force: boolean = false): void
		{
			var panelElement = angular.element('.gc-side-panel');
			var compressDisabled = panelElement.hasClass('js-disable-compress');
			var disableForElement = $(event.target).hasClass('js-disable-close-directive');

			if (!disableForElement && panelElement.length && (!panelElement.get(0).contains(event.target) || force)) {
				var body = angular.element('body');
				if (!compressDisabled && this.$window.matchMedia("(max-width: 1200px)").matches) {
					event.preventDefault();
					panelElement.find('.js-close-panel').click();
				} else if (!compressDisabled && !body.hasClass('panel-is-compressed')) {
					event.preventDefault();
					body.addClass('panel-is-compressed');
				} else if (compressDisabled || force) {
					panelElement.find('.js-close-panel').click();
				}
				try {
					scope.$apply();
				} catch (err) {} // to prevent duplicate $apply()
			}
		}

	}

	CloseDirective.register(angular, 'close', ['dialogService', '$window', 'FoundationApi']);

}
