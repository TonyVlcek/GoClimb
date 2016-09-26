namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import Authorizator = GoClimb.Admin.Services.Authorizator;

	export class DashboardState extends BaseState
	{

		public url = '/';
		public templateUrl = 'app/client/Admin/ts/templates/Dashboard/default.html';
		public controller = 'DashboardController as dashboardCtrl';

		public onEnter = ['authorizator', (authorizator: Authorizator) => {

			return authorizator.isAllowed('admin.dashboard');

		}];

	}

	DashboardState.register(angular, 'dashboard');

}
