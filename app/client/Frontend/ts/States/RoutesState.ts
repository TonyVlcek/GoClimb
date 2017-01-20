namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class RoutesState extends BaseState
	{

		public url = '/';
		public templateUrl = 'app/client/Frontend/ts/templates/Routes/default.html';
		public controller = 'RoutesController as routesCtrl';

	}

	RoutesState.register(angular, 'routes');

}
