namespace GoClimb.Frontend.States
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

	export class LogCreateState extends BasePanelState
	{

		public url = 'create/{type}/{id}';
		public templateUrl = 'app/client/Frontend/ts/templates/Logs/create.html';
		public resolve = {
			log: (): ILog => {
				return {
					style: null,
					route: null,
					loggedDate: new Date,
					description: null,
				};
			},
			styles: ['stylesFacade', (stylesFacade: StylesFacade) => {
				return new Promise((resolve) => {
					stylesFacade.getStyles((styles) => {
						resolve(styles);
					})
				});
			}],
			route: ['$stateParams', 'ropesFacade', 'bouldersFacade', ($stateParams, ropesFacade: RopesFacade, bouldersFacade: BouldersFacade) => {
				switch ($stateParams.type) {
					case 'rope':
						return new Promise((resolve, reject) => {
							ropesFacade.getRope($stateParams.id, (rope) => {
								if (rope) {
									resolve(rope);
								} else {
									reject();
								}
							});
						});
					case 'boulder':
						return new Promise((resolve, reject) => {
							bouldersFacade.getBoulder($stateParams.id, (boulder) => {
								if (boulder) {
									resolve(boulder);
								} else {
									reject();
								}
							});
						});
					default:
						return null;
				}
			}]
		};


		public controller = ['$scope', 'route', 'log', 'styles', '$state', 'flashMessageSender', 'logsFacade', ($scope, route, log, styles, $state: IStateService, flashMessageSender: FlashMessageSender, logsFacade: LogsFacade) => {
			this.data.canLeave = () => {
				return !($scope.logForm && $scope.logForm.$dirty);
			};

			$scope.saving = false;
			$scope.log = log;
			$scope.styles = styles;
			$scope.route = route;

			$scope.save = () => {
				if ($scope.logForm.$invalid) {
					flashMessageSender.sendError('flashes.logs.error.invalidForm');
					return;
				}

				$scope.saving = true;

				logsFacade.createLog($scope.log, route, (log: ILog) => {
					$scope.logForm.$setPristine();
					$scope.saving = false;
					flashMessageSender.sendSuccess('flashes.logs.created.success');
					$state.go('^');
				});
			};
		 }];

	}

	LogCreateState.register(angular, 'logs.create');

}
