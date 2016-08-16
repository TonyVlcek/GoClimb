namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class SettingsState extends BaseState
	{

		public url = '/settings';
		public templateUrl = 'app/client/Admin/ts/templates/Settings/default.html';
		public controller = 'SettingsController as settingsCtrl';

	}

	SettingsState.register(angular, 'settings');

}
