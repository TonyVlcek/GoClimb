namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import EventsFacade = GoClimb.Core.Model.Facades.EventsFacade;
	import IEvent = GoClimb.Core.Model.Entities.IEvent;

	export class EventCreateState extends BasePanelState
	{

		public url = '/create';
		public templateUrl = 'app/client/Admin/ts/templates/Events/create.html';
		public resolve = {
			event: () => {
				return {
					'name': null,
					'content': null,
					'startDate': null,
					'endDate': null,
				}
			}
		};


		public controller = ['$scope', 'event', 'eventsFacade', 'flashMessageSender', '$state', ($scope, event, eventsFacade: EventsFacade, flashMessageSender: FlashMessageSender, $state: IStateService) => {
			this.data.canLeave = () => {
				return !($scope.eventForm && $scope.eventForm.$dirty);
			};

			$scope.processingSave = false;
			$scope.processingSaveAsDraft = false;
			$scope.event = event;

			$scope.save = (publish: boolean = false) => {
				if ($scope.eventForm.$invalid) {
					flashMessageSender.sendError('flashes.events.error.invalidForm');
					return;
				}

				var message: string;
				if (!publish) {
					$scope.processingSaveAsDraft = true;
					message = 'flashes.events.savedAsDraft';
				} else if ($scope.event.published && publish) {
					$scope.processingSave = true;
					message = 'flashes.events.saved';
				} else {
					$scope.processingSave = true;
					message = 'flashes.events.savedAndPublished';
				}

				eventsFacade.createEvent($scope.event, publish, (event: IEvent) => {
					$scope.eventForm.$setPristine();
					$scope.processingSave = false;
					$scope.processingSaveAsDraft = false;
					flashMessageSender.sendSuccess(message);
					$state.go('events.edit', {id: event.id});
				});
			};

			$scope.isProcessing = () => {
				return $scope.processingSave || $scope.processingSaveAsDraft;
			};

		}];

	}

	EventCreateState.register(angular, 'events.create');

}
