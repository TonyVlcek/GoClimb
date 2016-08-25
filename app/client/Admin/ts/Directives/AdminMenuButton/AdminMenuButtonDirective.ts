namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;

	export class AdminMenuButtonDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Admin/ts/Directives/AdminMenuButton/AdminMenuButtonDirective.html';

	}

	AdminMenuButtonDirective.register(angular, 'adminMenuButton');

}
