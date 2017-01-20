namespace GoClimb.Frontend.States
{


	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import RopesFacade = GoClimb.Core.Model.Facades.RopesFacade;
	import BouldersFacade = GoClimb.Core.Model.Facades.BouldersFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;

	export class RouteDetailState extends BasePanelState
	{

		public url = '{type}/{id}';
		public templateUrl = 'app/client/Frontend/ts/templates/Routes/detail.html';
		public resolve = {
			route: ['$stateParams', 'ropesFacade', 'bouldersFacade', ($stateParams, ropesFacade: RopesFacade, bouldersFacade: BouldersFacade) =>
			{
				switch ($stateParams.type) {
					case 'rope':
						return new Promise((resolve, reject) =>
						{
							ropesFacade.getRope($stateParams.id, (rope) =>
							{
								if (rope) {
									resolve(rope);
								} else {
									reject();
								}
							});
						});
					case 'boulder':
						return new Promise((resolve, reject) =>
						{
							bouldersFacade.getBoulder($stateParams.id, (boulder) =>
							{
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


		public controller = ['$scope', 'route', '$stateParams', ($scope, route, $stateParams) => {
			$scope.type = $stateParams.type;
			$scope.route = route;

			//           0 1 2 3 4 5
			var stars = [0,0,0,0,0,0];

			for (var i in route.ratings) {
				stars[route.ratings[i].rating] += 1;
			}


			$scope.average = Math.round((5 * stars[5] + 4 * stars[4] + 3 * stars[3] + 2 * stars[2] + stars[1]) / (stars[5] + stars[4] + stars[3] + stars[2] + stars[1]) * 100) / 100;

			$scope.range = (n) => {
				return new Array(n);
			};
		}];

	}

	RouteDetailState.register(angular, 'routes.detail');

}
