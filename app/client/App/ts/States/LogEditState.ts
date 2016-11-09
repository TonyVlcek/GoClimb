namespace GoClimb.App.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import IStateService = angular.ui.IStateService;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import StylesFacade = GoClimb.Core.Model.Facades.StylesFacade;
	import ILog = GoClimb.Core.Model.Entities.ILog;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import LogsFacade = GoClimb.Core.Model.Facades.LogsFacade;
	import BouldersFacade = GoClimb.Core.Model.Facades.BouldersFacade;
	import RopesFacade = GoClimb.Core.Model.Facades.RopesFacade;

	export class LogEditState extends BasePanelState
	{

		public url = 'edit/{id}';
		public templateUrl = 'app/client/App/ts/templates/Dashboard/edit.html';
		public controller = ['$scope', 'log', 'styles', '$state', 'flashMessageSender', 'logsFacade', ($scope, log, styles, $state: IStateService, flashMessageSender: FlashMessageSender, logsFacade: LogsFacade) => {
			this.data.canLeave = () => {
				return !($scope.logForm && $scope.logForm.$dirty);
			};

			$scope.saving = false;
			$scope.log = log;
			$scope.styles = styles;

			$scope.save = () => {
				if ($scope.logForm.$invalid) {
					flashMessageSender.sendError('flashes.logs.error.invalidForm');
					return;
				}

				$scope.saving = true;
				logsFacade.updateLog($scope.log, (log: ILog) => {
					$scope.logForm.$setPristine();
					$scope.saving = false;
					flashMessageSender.sendSuccess('flashes.logs.saved');
					$state.go('^');
				});
			};
		}];


		public resolve = {
			log: ['$stateParams', 'logsFacade', ($stateParams, logsFacade: LogsFacade) => {
				return new Promise((resolve, reject) => {
					logsFacade.getLog($stateParams.id.toString(), function (log) {
						resolve(angular.copy(log));
					});
				});
			}],

			styles: ['stylesFacade', (stylesFacade: StylesFacade) => {
				return new Promise((resolve) => {
					stylesFacade.getStyles((styles) => {
						resolve(styles);
					})
				});
			}]
		};

	}

	LogEditState.register(angular, 'dashboard.edit');

}
