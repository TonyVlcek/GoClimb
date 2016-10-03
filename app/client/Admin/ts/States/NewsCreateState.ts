namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import NewsFacade = GoClimb.Core.Model.Facades.NewsFacade;
	import INews = GoClimb.Core.Model.Entities.INews;

	export class NewsCreateState extends BasePanelState
	{

		public url = '/create';
		public templateUrl = 'app/client/Admin/ts/templates/News/create.html';
		public resolve = {
			news: () => {
				return {
					'content': null,
				}
			}
		};


		public controller = ['$scope', 'news', 'newsFacade', 'flashMessageSender', '$state', ($scope, news, newsFacade: NewsFacade, flashMessageSender: FlashMessageSender, $state: IStateService) => {
			this.data.canLeave = () => {
				return !($scope.newsForm && $scope.newsForm.$dirty);
			};

			$scope.processingSave = false;
			$scope.processingSaveAsDraft = false;
			$scope.news = news;

			$scope.save = () => {
				if ($scope.newsForm.$invalid) {
					flashMessageSender.sendError('flashes.news.error.invalidForm');
					return;
				}

				$scope.processingSave = true;
				var message = 'flashes.news.savedAndPublished';

				newsFacade.createNews($scope.news, (news: INews) => {
					$scope.newsForm.$setPristine();
					$scope.processingSave = false;
					$scope.processingSaveAsDraft = false;
					flashMessageSender.sendSuccess(message);
					$state.go('news.edit', {id: news.id});
				});
			};

			$scope.isProcessing = () => {
				return $scope.processingSave || $scope.processingSaveAsDraft;
			};

		}];

	}

	NewsCreateState.register(angular, 'news.create');

}
