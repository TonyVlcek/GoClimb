namespace GoClimb.Admin.Model.Facades
{

	import HttpService = GoClimb.Admin.Model.Http.HttpService;
	import Utils = GoClimb.Core.Utils.Utils;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import IArticle = GoClimb.Admin.Model.Entities.IArticle;

	export class ArticlesFacade extends BaseFacade
	{

		private articles: IndexedArray<IArticle> = null;

		private loading: boolean = false;


		public getArticles(callback: (articles: IndexedArray<IArticle>) => void = null, errorCallback: Function = null)
		{
			if (this.articles === null && this.loading === false) {
				this.loading = true;
				this.httpService.requestGet('articles/', (data) => {
					for (var id in data.articles) {
						data.articles[id] = ArticlesFacade.mapArticle(data.articles[id]);
					}
					this.articles = new IndexedArray<IArticle>(data.articles);
					this.loading = false;
					if (callback) {
						callback(this.articles);
					}
				}, {}, errorCallback);
			} else if (this.articles) {
				callback(this.articles);
			}
		}


		public getArticle(id: string, callback: (article: IArticle) => void = null, errorCallback: Function = null)
		{
			this.getArticles((articles) => {
				callback(articles.getIndex(id));
			}, errorCallback);
		}


		public createArticle(article: IArticle, publish: boolean, callback: (article: IArticle) => void = null, errorCallback: Function = null): ArticlesFacade
		{
			article = angular.copy(article);
			article.published = publish;
			article = ArticlesFacade.articleToJson(article);
			this.httpService.requestPost('articles/', {article: article}, (data) => {
				this.articles.setIndex(data.article.id.toString(), ArticlesFacade.mapArticle(data.article));
				if (callback) {
					callback(this.articles.getIndex(data.article.id.toString()));
				}
			}, errorCallback);
			return this;
		}


		public updateArticle(article: IArticle, publish: boolean, callback: (article: IArticle) => void = null, errorCallback: Function = null): ArticlesFacade
		{
			article = angular.copy(article);
			article.published = publish;
			article = ArticlesFacade.articleToJson(article);
			this.httpService.requestPost('articles/' + article.id, {article: article}, (data) => {
				this.articles.setIndex(data.article.id.toString(), ArticlesFacade.mapArticle(data.article));
				if (callback) {
					callback(this.articles.getIndex(data.article.id.toString()));
				}
			}, errorCallback);
			return this;
		}


		public deleteArticle(article: IArticle, callback: () => void = null, errorCallback: Function = null): ArticlesFacade
		{
			article = angular.copy(article);
			this.httpService.requestDelete('articles/' + article.id, {}, () => {
				this.articles.removeIndex(article.id.toString());
				if (callback) {
					callback();
				}
			}, errorCallback);
			return this;
		}


		private static mapArticle(article: IArticle): IArticle
		{
			if (article.published) {
				article.publishedDate = Utils.stringToDate(article.publishedDate);
			}

			return article;
		}


		private static articleToJson(article: IArticle): IArticle
		{
			if (article.published && article.publishedDate) {
				article.publishedDate = Utils.dateToString(article.publishedDate);
			}

			return article;
		}
	}

	ArticlesFacade.register(angular, 'articlesFacade', ['httpService']);

}
