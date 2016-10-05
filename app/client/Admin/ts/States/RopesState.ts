namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class RopesState extends BaseState
	{

		public url = '/routes/ropes';
		public templateUrl = 'app/client/Admin/ts/templates/Ropes/default.html';
		public controller = 'RopesController as ropesCtrl';

	}

	RopesState.register(angular, 'ropes');

}
