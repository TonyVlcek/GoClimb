namespace GoClimb.App.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class ProfileState extends BaseState
	{

		public url = '/profile';
		public templateUrl = 'app/client/App/ts/templates/Profile/default.html';
		public controller = 'ProfileController as profileCtrl';

	}

	ProfileState.register(angular, 'profile');

}
