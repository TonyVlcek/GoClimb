namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;

	export class AdminMenuDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Admin/ts/Directives/AdminMenu/AdminMenuDirective.html';
	}

	AdminMenuDirective.register(angular, 'adminMenu');

}
