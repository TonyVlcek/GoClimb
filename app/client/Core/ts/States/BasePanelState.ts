namespace GoClimb.Core.States
{

	import IAngularStatic = angular.IAngularStatic;
	import IStateProvider = angular.ui.IStateProvider;
	import IState = angular.ui.IState;


	export abstract class BasePanelState extends BaseState
	{

		private unbindWatch;

		public data = {
			canLeave: () => { return true; },
			leaveMessage: 'forms.common.unsavedData',
		};

		public onEnter = ['$rootScope', ($rootScope) => {
			angular.element('body').addClass('panel-is-active');

			//Fix for translating from open panel to another open panel
			var unbind = $rootScope.$on('$viewContentAnimationEnded', () => {
				angular.element('body').addClass('panel-is-active');
				unbind();
			});
		}];

		public onExit = ['dialogService', '$rootScope', (dialogService: any, $rootScope) => {
			if (this.data.canLeave() || dialogService.confirm(this.data.leaveMessage)) {
				angular.element('body').addClass('panel-is-closing');

				var unbind = $rootScope.$on('$viewContentAnimationEnded', () => {
					angular.element('body').removeClass('panel-is-active');
					angular.element('body').removeClass('panel-is-closing');
					unbind();
				});
				return true;
			} else {
				return false;
			}
		}];
	}

}
