namespace GoClimb.Admin.States
{

	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import NewsFacade = GoClimb.Admin.Model.Facades.NewsFacade;
	import INews = GoClimb.Admin.Model.Entities.INews;

	export class NewsEditState extends BasePanelState
	{

		public url = '/edit/{id}';
		public templateUrl = 'app/client/Admin/ts/templates/News/edit.html';

		public resolve = {
			news: ['$stateParams', 'newsFacade', ($stateParams, newsFacade: NewsFacade) => {
				return new Promise((resolve, reject) => {
					newsFacade.getNews($stateParams.id.toString(), function (news) {
						resolve(angular.copy(news));
					});
				});
			}]
		};

		public controller = ['$scope', 'news', 'newsFacade', 'flashMessageSender', ($scope, news, newsFacade: NewsFacade, flashMessageSender: FlashMessageSender) => {
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
				var message = 'flashes.news.saved';

				newsFacade.updateNews($scope.news, (news: INews) => {
					$scope.news = news;
					$scope.newsForm.$setPristine();
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

	NewsEditState.register(angular, 'news.edit');

}
