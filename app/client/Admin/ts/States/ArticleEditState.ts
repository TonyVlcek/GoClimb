namespace GoClimb.Admin.States
{

	import ArticlesFacade = GoClimb.Admin.Model.Facades.ArticlesFacade;
	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import IArticle = GoClimb.Admin.Model.Entities.IArticle;
	import BasePanelState = GoClimb.Core.States.BasePanelState;

	export class ArticleEditState extends BasePanelState
	{

		public url = '/edit/{id}';
		public templateUrl = 'app/client/Admin/ts/templates/Articles/edit.html';

		public resolve = {
			article: ['$stateParams', 'articlesFacade', ($stateParams, articlesFacade: ArticlesFacade) => {
				return new Promise((resolve, reject) => {
					articlesFacade.getArticle($stateParams.id.toString(), function (article) {
						resolve(angular.copy(article));
					});
				});
			}]
		};

		public controller = ['$scope', 'article', 'articlesFacade', 'flashMessageSender', ($scope, article, articlesFacade: ArticlesFacade, flashMessageSender: FlashMessageSender) => {
			this.data.canLeave = () => {
				return !($scope.articleForm && $scope.articleForm.$dirty);
			};

			$scope.processingSave = false;
			$scope.processingSaveAsDraft = false;
			$scope.article = article;

			$scope.save = (publish: boolean = false) => {
				if ($scope.articleForm.$invalid) {
					flashMessageSender.sendError('flashes.articles.error.invalidForm');
					return;
				}

				var message: string;
				if (!publish) {
					$scope.processingSaveAsDraft = true;
					message = 'flashes.articles.savedAsDraft';
				} else if ($scope.article.published && publish) {
					$scope.processingSave = true;
					message = 'flashes.articles.saved';
				} else {
					$scope.processingSave = true;
					message = 'flashes.articles.savedAndPublished';
				}

				articlesFacade.updateArticle($scope.article, publish, (article: IArticle) => {
					$scope.article = article;
					$scope.articleForm.$setPristine();
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

	ArticleEditState.register(angular, 'articles.edit');

}
