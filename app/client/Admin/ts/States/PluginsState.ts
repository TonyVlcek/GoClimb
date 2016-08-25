namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class PluginsState extends BaseState
	{

		public url = '/plugins';
		public templateUrl = 'app/client/Admin/ts/templates/Plugins/default.html';
		public controller = 'PluginsController as pluginsCtrl';

	}

	PluginsState.register(angular, 'plugins');

}
