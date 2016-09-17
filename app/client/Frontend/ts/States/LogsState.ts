namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class LogsState extends BaseState
	{

		public url = '/';
		public templateUrl = 'app/client/Frontend/ts/templates/Logs/default.html';
		public controller = 'LogsController as logsCtrl';

	}

	LogsState.register(angular, 'logs');

}
