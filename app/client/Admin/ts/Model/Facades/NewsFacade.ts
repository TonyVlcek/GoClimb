namespace GoClimb.Admin.Model.Facades
{

	import HttpService = GoClimb.Admin.Model.Http.HttpService;
	import Utils = GoClimb.Core.Utils.Utils;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import INews = GoClimb.Admin.Model.Entities.INews;

	export class NewsFacade extends BaseFacade
	{

		private news: IndexedArray<INews> = null;

		private loading: boolean = false;


		public getAllNews(callback: (news: IndexedArray<INews>) => void = null, errorCallback: Function = null)
		{
			if (this.news === null && this.loading === false) {
				this.loading = true;
				this.httpService.requestGet('news/', (data) => {
					for (var id in data.news) {
						data.news[id] = NewsFacade.mapNews(data.news[id]);
					}
					this.news = new IndexedArray<INews>(data.news);
					this.loading = false;
					if (callback) {
						callback(this.news);
					}
				}, {}, errorCallback);
			} else if (this.news) {
				callback(this.news);
			}
		}


		public getNews(id: string, callback: (news: INews) => void = null, errorCallback: Function = null)
		{
			this.getAllNews((news) => {
				callback(news.getIndex(id));
			}, errorCallback);
		}


		public createNews(news: INews, callback: (news: INews) => void = null, errorCallback: Function = null): NewsFacade
		{
			news = angular.copy(news);
			news.published = true;
			news = NewsFacade.newsToJson(news);
			this.httpService.requestPost('news/', {news: news}, (data) => {
				this.news.setIndex(data.news.id.toString(), NewsFacade.mapNews(data.news));
				if (callback) {
					callback(this.news.getIndex(data.news.id.toString()));
				}
			}, errorCallback);
			return this;
		}


		public updateNews(news: INews, callback: (news: INews) => void = null, errorCallback: Function = null): NewsFacade
		{
			news = angular.copy(news);
			news.published = true;
			news = NewsFacade.newsToJson(news);
			this.httpService.requestPost('news/' + news.id, {news: news}, (data) => {
				this.news.setIndex(data.news.id.toString(), NewsFacade.mapNews(data.news));
				if (callback) {
					callback(this.news.getIndex(data.news.id.toString()));
				}
			}, errorCallback);
			return this;
		}


		public deleteNews(news: INews, callback: () => void = null, errorCallback: Function = null): NewsFacade
		{
			news = angular.copy(news);
			this.httpService.requestDelete('news/' + news.id, {}, () => {
				this.news.removeIndex(news.id.toString());
				if (callback) {
					callback();
				}
			}, errorCallback);
			return this;
		}


		private static mapNews(news: INews): INews
		{
			news.publishedDate = Utils.stringToDate(news.publishedDate);
			return news;
		}


		private static newsToJson(news: INews): INews
		{
			if (news.publishedDate) {
				news.publishedDate = Utils.dateToString(news.publishedDate);
			}

			return news;
		}
	}

	NewsFacade.register(angular, 'newsFacade', ['httpService']);

}
