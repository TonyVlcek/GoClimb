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
	import UserService = GoClimb.Admin.Services.UserService;
	import IRoute = GoClimb.Core.Model.Entities.IRoute;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import RatingFacade = GoClimb.Core.Model.Facades.RatingFacade;
	import IRating = GoClimb.Core.Model.Entities.IRating;

	export class LogCreateState extends BasePanelState
	{

		public url = 'create/log/{type}/{id}';
		public templateUrl = 'app/client/Frontend/ts/templates/Routes/createLog.html';
		public resolve = {
			user: ['userService', (userService: UserService) => {
				userService.requireLogin();
			}],
			log: (): ILog => {
				return {
					style: null,
					route: null,
					loggedDate: new Date,
					description: null,
					tries: 1
				};
			},
			route: ['$stateParams', 'ropesFacade', 'bouldersFacade', 'flashMessageSender', '$state', ($stateParams, ropesFacade: RopesFacade, bouldersFacade: BouldersFacade, flashMessageSender: FlashMessageSender, $state) => {
				switch ($stateParams.type) {
					case 'rope':
						return new Promise((resolve, reject) => {
							ropesFacade.getRope($stateParams.id, (rope) => {
								if (rope) {
									if (rope.dateRemoved && Date.now() > Date.parse(rope.dateRemoved)) {
										flashMessageSender.sendError('flashes.logs.error.removed');
										$state.go('logs');
										reject();
									}
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
									if (boulder.dateRemoved && Date.now() > Date.parse(boulder.dateRemoved)) {
										flashMessageSender.sendError('flashes.logs.error.removed');
										$state.go('logs');
										reject();
									}
									resolve(boulder);
								} else {
									reject();
								}
							});
						});
					default:
						return null;
				}
			}],
			styles: ['stylesFacade', 'route', (stylesFacade: StylesFacade, route: IRoute) =>
			{
				return new Promise((resolve) => {
					stylesFacade.getStylesForLog(route.id, (styles) => {
						resolve(styles);
					})
				});
			}]
		};


		public controller = ['$scope', 'route', 'log', 'styles', '$state', 'flashMessageSender', 'logsFacade', 'ratingFacade', 'userService', ($scope, route, log, styles, $state: IStateService, flashMessageSender: FlashMessageSender, logsFacade: LogsFacade, ratingFacade: RatingFacade, userService: UserService) =>
		{
			this.data.canLeave = () => {
				return !($scope.logForm && $scope.logForm.$dirty);
			};

			$scope.saving = false;
			$scope.disableTries = false;
			$scope.allreadyRated = false;
			$scope.rating = {
				'note': null,
				'rating': null,
				'route': {
					'id': null
				}
			};

			for (var i in route.ratings){
				if (route.ratings[i].author.id == userService.getUserId()){
					$scope.allreadyRated = true;
				}
			}


			$scope.log = log;
			$scope.styles = angular.copy(styles);
			$scope.route = route;
			$scope.log.style = null;

			//Fix weird bug, when form is set to dirty after it was create.
			setTimeout(() => {
				$scope.logForm.$setPristine();
				$scope.$apply();
			}, 300);

			$scope.save = () => {
				if ($scope.logForm.$invalid) {
					flashMessageSender.sendError('flashes.logs.error.invalidForm');
					return;
				}

				$scope.saving = true;

				if (!$scope.allreadyRated && $scope.rating.note) {
					$scope.rating.route.id = $scope.route.id;
					ratingFacade.addRating($scope.rating, (rating: IRating) => {
						route.ratings.push(rating);
						flashMessageSender.sendSuccess('flashes.rating.added');
					});
				}

				logsFacade.createLog($scope.log, route, (log: ILog) => {
					$scope.logForm.$setPristine();
					$scope.saving = false;
					flashMessageSender.sendSuccess('flashes.logs.created');
					$state.go('^');
				});
			};

			$scope.setTries = () => {
				for (var i in styles) {
					if (styles[i].id == $scope.log.style && (styles[i].name == 'flash' || styles[i].name == 'os')){
						$scope.disableTries = true;
						$scope.log.tries = 1;
						return;
					}
				}
				$scope.disableTries = false;
			};

			$scope.explainTries = () => {
				if ($scope.disableTries){
					flashMessageSender.sendInfo('flashes.logs.error.explainTries', '', 10);
				}
			};

			$scope.explainRating = () => {
				if (!$scope.rating.note){
					flashMessageSender.sendInfo('flashes.logs.error.explainRating', '', 10);
				}
			}
		}];

	}

	LogCreateState.register(angular, 'routes.create');

}
