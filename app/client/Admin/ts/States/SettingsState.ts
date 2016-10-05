namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import Authorizator = GoClimb.Admin.Services.Authorizator;

	export class SettingsState extends BaseState
	{

		public url = '/settings';
		public templateUrl = 'app/client/Admin/ts/templates/Settings/default.html';
		public controller = 'SettingsController as settingsCtrl';

		public onEnter = ['authorizator', (authorizator: Authorizator) => {

			return authorizator.isAllowed('admin.settings.advanced');

		}];

	}

	SettingsState.register(angular, 'settings');

}
