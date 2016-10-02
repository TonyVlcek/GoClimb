namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class BouldersState extends BaseState
	{

		public url = '/routes/boulders';
		public templateUrl = 'app/client/Admin/ts/templates/Boulders/default.html';
		public controller = 'BouldersController as bouldersCtrl';

	}

	BouldersState.register(angular, 'boulders');

}
