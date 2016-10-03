namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import ArticlesFacade = GoClimb.Core.Model.Facades.ArticlesFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import IArticle = GoClimb.Core.Model.Entities.IArticle;
	import BasePanelState = GoClimb.Core.States.BasePanelState;

	export class ArticleCreateState extends BasePanelState
	{

		public url = '/create';
		public templateUrl = 'app/client/Admin/ts/templates/Articles/create.html';
		public resolve = {
			article: () => {
				return {
					'name': null,
					'content': null,
				}
			}
		};


		public controller = ['$scope', 'article', 'articlesFacade', 'flashMessageSender', '$state', ($scope, article, articlesFacade: ArticlesFacade, flashMessageSender: FlashMessageSender, $state: IStateService) => {
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

				articlesFacade.createArticle($scope.article, publish, (article: IArticle) => {
					$scope.articleForm.$setPristine();
					$scope.processingSave = false;
					$scope.processingSaveAsDraft = false;
					flashMessageSender.sendSuccess(message);
					$state.go('articles.edit', {id: article.id});
				});
			};

			$scope.isProcessing = () => {
				return $scope.processingSave || $scope.processingSaveAsDraft;
			};

		}];

	}

	ArticleCreateState.register(angular, 'articles.create');

}
