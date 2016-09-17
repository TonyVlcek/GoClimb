namespace GoClimb.Frontend.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import IStateService = angular.ui.IStateService;
	import BasePanelState = GoClimb.Core.States.BasePanelState;

	export class LogCreateState extends BasePanelState
	{

		public url = 'create';
		public templateUrl = 'app/client/Frontend/ts/templates/Logs/create.html';
		public resolve = {
			log: () => {
				return {
					'name': null,
				}
			}
		};


		public controller = ['$scope', 'log', '$state', ($scope, log, $state: IStateService) => {
			$scope.today = new Date();
			// this.data.canLeave = () => {
			// 	return !($scope.articleForm && $scope.articleForm.$dirty);
			// };
			//
			// $scope.processingSave = false;
			// $scope.processingSaveAsDraft = false;
			// $scope.article = article;

			// 	$scope.save = (publish: boolean = false) => {
			// 		if ($scope.articleForm.$invalid) {
			// 			flashMessageSender.sendError('flashes.articles.error.invalidForm');
			// 			return;
			// 		}
			//
			// 		var message: string;
			// 		if (!publish) {
			// 			$scope.processingSaveAsDraft = true;
			// 			message = 'flashes.articles.savedAsDraft';
			// 		} else if ($scope.article.published && publish) {
			// 			$scope.processingSave = true;
			// 			message = 'flashes.articles.saved';
			// 		} else {
			// 			$scope.processingSave = true;
			// 			message = 'flashes.articles.savedAndPublished';
			// 		}
			//
			// 		articlesFacade.createArticle($scope.article, publish, (article: IArticle) => {
			// 			$scope.articleForm.$setPristine();
			// 			$scope.processingSave = false;
			// 			$scope.processingSaveAsDraft = false;
			// 			flashMessageSender.sendSuccess(message);
			// 			$state.go('articles.edit', {id: article.id});
			// 		});
			// 	};
			//
			// 	$scope.isProcessing = () => {
			// 		return $scope.processingSave || $scope.processingSaveAsDraft;
			// 	};
			//
		 }];

	}

	LogCreateState.register(angular, 'logs.create');

}
