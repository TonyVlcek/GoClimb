namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class ErrorState extends BaseState
	{

		public templateUrl = 'app/client/Admin/ts/templates/Error/404.html';

	}

	ErrorState.register(angular, '404');

}
