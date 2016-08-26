namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class EventsState extends BaseState
	{

		public url = '/events';
		public templateUrl = 'app/client/Admin/ts/templates/Events/default.html';
		public controller = 'EventsController as eventsCtrl';

	}

	EventsState.register(angular, 'events');

}
