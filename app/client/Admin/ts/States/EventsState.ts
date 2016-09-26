namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import Authorizator = GoClimb.Admin.Services.Authorizator;

	export class EventsState extends BaseState
	{

		public url = '/events';
		public templateUrl = 'app/client/Admin/ts/templates/Events/default.html';
		public controller = 'EventsController as eventsCtrl';

		public onEnter = ['authorizator', (authorizator: Authorizator) => {

			return authorizator.isAllowed('admin.events');

		}];

	}

	EventsState.register(angular, 'events');

}
