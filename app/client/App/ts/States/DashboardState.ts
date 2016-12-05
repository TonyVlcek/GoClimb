namespace GoClimb.App.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class DashboardState extends BaseState
	{

		public url = '/';
		public templateUrl = 'app/client/App/ts/templates/Dashboard/default.html';
		public controller = 'DashboardController as dashboardCtrl';

	}

	DashboardState.register(angular, 'dashboard');

}
