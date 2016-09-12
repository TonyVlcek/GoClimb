
namespace GoClimb.Admin.Controllers
{
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import INews = GoClimb.Admin.Model.Entities.INews;
	import NewsFacade = GoClimb.Admin.Model.Facades.NewsFacade;


	export class NewsController extends BaseAdminController
	{

		public processingDelete: number = null;

		private news: IndexedArray<INews> = null;
		private loading: boolean = false;

		private flashMessageSender: FlashMessageSender;
		private dialogService: DialogService;
		private newsFacade: NewsFacade;


		public constructor(flashMessageSender: FlashMessageSender, dialogService: DialogService, newsFacade: NewsFacade)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.dialogService = dialogService;
			this.newsFacade = newsFacade;
		}


		public deleteNews(news: INews)
		{
			if (!this.dialogService.confirm('flashes.news.delete')) {
				return;
			}

			this.processingDelete = news.id;
			this.newsFacade.deleteNews(news, () => {
				this.processingDelete = null;
				this.flashMessageSender.sendSuccess('flashes.news.deleted.success');
			});
		}


		public getNews(): IndexedArray<INews>
		{
			if (!this.loading && !this.news) {
				this.loading = true;
				this.newsFacade.getAllNews((articles) => {
					this.loading = false;
					this.news = articles;
				});
			}
			return this.news;
		}

	}

	NewsController.register(angular, 'NewsController', ['flashMessageSender', 'dialogService', 'newsFacade']);

}
