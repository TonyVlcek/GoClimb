namespace GoClimb.Admin.States
{

	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import EventsFacade = GoClimb.Admin.Model.Facades.EventsFacade;
	import IEvent = GoClimb.Admin.Model.Entities.IEvent;

	export class EventEditState extends BasePanelState
	{

		public url = '/edit/{id}';
		public templateUrl = 'app/client/Admin/ts/templates/Events/edit.html';

		public resolve = {
			event: ['$stateParams', 'eventsFacade', ($stateParams, eventsFacade: EventsFacade) => {
				return new Promise((resolve, reject) => {
					eventsFacade.getEvent($stateParams.id.toString(), function (event) {
						resolve(angular.copy(event));
					});
				});
			}]
		};

		public controller = ['$scope', 'event', 'eventsFacade', 'flashMessageSender', ($scope, event, eventsFacade: EventsFacade, flashMessageSender: FlashMessageSender) => {
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

				eventsFacade.updateEvent($scope.event, publish, (event: IEvent) => {
					$scope.event = event;
					$scope.eventForm.$setPristine();
					$scope.processingSave = false;
					$scope.processingSaveAsDraft = false;
					flashMessageSender.sendSuccess(message);
				});
			};

			$scope.isProcessing = () => {
				return $scope.processingSave || $scope.processingSaveAsDraft;
			};

		}];

	}

	EventEditState.register(angular, 'events.edit');

}
