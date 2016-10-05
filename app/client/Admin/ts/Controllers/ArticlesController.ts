namespace GoClimb.Admin.Controllers
{
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import ArticlesFacade = GoClimb.Core.Model.Facades.ArticlesFacade;
	import IArticle = GoClimb.Core.Model.Entities.IArticle;


	export class ArticlesController extends BaseAdminController
	{

		public processingDelete: number = null;

		private articles: IndexedArray<IArticle> = null;
		private loading: boolean = false;

		private flashMessageSender: FlashMessageSender;
		private dialogService: DialogService;
		private articlesFacade: ArticlesFacade;


		public constructor(flashMessageSender: FlashMessageSender, dialogService: DialogService, articlesFacade: ArticlesFacade)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.dialogService = dialogService;
			this.articlesFacade = articlesFacade;
		}


		public deleteArticle(article: IArticle)
		{
			if (!this.dialogService.confirm('flashes.articles.delete')) {
				return;
			}

			this.processingDelete = article.id;
			this.articlesFacade.deleteArticle(article, () => {
				this.processingDelete = null;
				this.flashMessageSender.sendSuccess('flashes.articles.deleted.success');
			});
		}


		public getArticles(): IndexedArray<IArticle>
		{
			if (!this.loading && !this.articles) {
				this.loading = true;
				this.articlesFacade.getArticles((articles) => {
					this.loading = false;
					this.articles = articles;
				});
			}
			return this.articles;
		}

	}

	ArticlesController.register(angular, 'ArticlesController', ['flashMessageSender', 'dialogService', 'articlesFacade']);

}
