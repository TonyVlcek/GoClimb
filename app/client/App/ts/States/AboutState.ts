namespace GoClimb.App.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class AboutState extends BaseState
	{

		public url = '/about';
		public templateUrl = 'app/client/App/ts/templates/About/default.html'

	}

	AboutState.register(angular, 'about');

}
