namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;

	export class AppDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Admin/ts/Directives/App/AppDirective.html';

	}

	AppDirective.register(angular, 'app');

}
