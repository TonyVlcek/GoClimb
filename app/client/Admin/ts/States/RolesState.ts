namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class RoleState extends BaseState
	{

		public url = '/roles';
		public templateUrl = 'app/client/Admin/ts/templates/Roles/default.html';
		public controller = 'RolesController as rolesCtrl';

	}

	RoleState.register(angular, 'roles');

}
