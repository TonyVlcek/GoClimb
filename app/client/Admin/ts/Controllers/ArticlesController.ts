namespace GoClimb.Admin.Controllers
{

	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
	import PanelSize = GoClimb.Admin.Services.PanelSize;
	import ArticlesFacade = GoClimb.Admin.Model.Facades.ArticlesFacade;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import PanelFactory = GoClimb.Admin.Services.PanelFactory;
	import Panel = GoClimb.Admin.Services.Panel;


	export class ArticlesController extends BaseAdminController
	{
		public panel: Panel;
		public newArticle: boolean;
		public articleForm: ng.IFormController;

		public processingSave: boolean = false;
		public processingSaveAsDraft: boolean = false;
		public processingDelete: boolean = false;

		public articles: IndexedArray = null;
		public article: any = null;

		private areArticlesLoading: boolean = false;

		private flashMessageSender: FlashMessageSender;
		private articlesFacade: ArticlesFacade;
		private $window: ng.IWindowService;
		private dialogService: DialogService;


		public constructor(panelFactory: PanelFactory, flashMessageSender: FlashMessageSender, articlesFacade: ArticlesFacade, $window, dialogService)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.articlesFacade = articlesFacade;
			this.$window = $window;
			this.dialogService = dialogService;

			this.panel = panelFactory.create('sidebar', true, PanelSize.EXPAND);
		}


		public openCreatePanel()
		{
			if (this.articleForm.$dirty && !this.panel.confirmClose()) {
				return;
			}

			this.newArticle = true;
			this.articleForm.$setPristine();
			this.reset();

			this.stopProcessing();
			this.panel.open();
		}


		public openEditPanel(article: Object)
		{
			if (this.articleForm.$dirty && !this.panel.confirmClose()) {
				return;
			}

			this.newArticle = false;
			this.articleForm.$setPristine();
			this.reset();

			this.article = angular.copy(article);
			this.stopProcessing();
			this.panel.open();
		}


		public closePanel()
		{
			if (this.articleForm.$dirty) {
				this.panel.close('confirm');
			}else{
				this.panel.close('done');
			}
		}


		public saveArticle(publish: boolean)
		{
			if (this.articleForm.$invalid) {
				this.flashMessageSender.sendError('flashes.articles.error.invalidForm');
				return;
			}

			var message: string;
			if (!publish) {
				this.processingSaveAsDraft = true;
				message = 'flashes.articles.savedAsDraft';
			} else if (this.article.published && publish) {
				this.processingSave = true;
				message = 'flashes.articles.saved';
			} else {
				this.processingSave = true;
				message = 'flashes.articles.savedAndPublished';
			}

			var that = this;
			var callback = function (data) {
				that.saveCallback(data, message);
			};
			if (that.newArticle) {
				this.articlesFacade.createArticle(this.article, publish, callback);
			} else {
				this.articlesFacade.updateArticle(this.article, publish, callback);
			}
		}


		public deleteArticle()
		{
			if (!this.dialogService.confirm('flashes.articles.delete')) {
				return;
			}

			this.processingDelete = true;
			var that = this;
			this.articlesFacade.deleteArticle(this.article, function (data) {
				that.articles.removeIndex(that.article.id);
				that.stopProcessing();
				that.flashMessageSender.sendSuccess('flashes.articles.deleted.success');
				that.panel.close('done');
				that.reset();
			});
		}


		public getArticles() : IndexedArray
		{
			var that = this;
			if (this.areArticlesLoading === false) {
				this.areArticlesLoading = true;
				this.articlesFacade.getArticles(function (data) {
					that.articles = new IndexedArray(data.articles);
				});
			}
			return this.articles;
		}


		public isProcessing(): boolean
		{
			return this.processingDelete || this.processingSave || this.processingSaveAsDraft;
		}


		private saveCallback(data, message : string)
		{
			this.article = angular.copy(data.article);
			this.articles.setIndex(data.article.id, data.article);
			if (this.newArticle) {
				this.newArticle = false;
			}
			this.stopProcessing();
			this.flashMessageSender.sendSuccess(message);
		}


		private stopProcessing()
		{
			this.processingDelete = false;
			this.processingSaveAsDraft = false;
			this.processingSave = false;
		}


		private reset()
		{
			this.article = {
				'name': null,
				'content': null
			};
		}

	}

	ArticlesController.register(angular, 'ArticlesController', ['panelFactory', 'flashMessageSender', 'articlesFacade', '$window', 'DialogService']);

}
