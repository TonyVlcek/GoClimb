namespace GoClimb.Core.States
{

	import IAngularStatic = angular.IAngularStatic;
	import IStateProvider = angular.ui.IStateProvider;


	export abstract class BasePanelState extends BaseState
	{

		public data = {
			canLeave: () => { return true; },
			leaveMessage: 'forms.common.unsavedData',
		};

		public onEnter = [() => {
			this.addPanelActiveClass();
		}];

		public onExit = ['dialogService', (dialogService: any) => {
			if (this.data.canLeave() || dialogService.confirm(this.data.leaveMessage)) {
				this.removePanelActiveClass();
				return true;
			} else {
				return false;
			}
		}];

		private addPanelActiveClass()
		{
			angular.element('body').addClass('panel-is-active');
		}

		private removePanelActiveClass()
		{
			angular.element('body').removeClass('panel-is-active');
		}

	}

}
