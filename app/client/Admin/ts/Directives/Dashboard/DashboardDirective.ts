namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;

	export class DashboardDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Admin/ts/Directives/Dashboard/DashboardDirective.html';

	}

	DashboardDirective.register(angular, 'dashboard');

}
