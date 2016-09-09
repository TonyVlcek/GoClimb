namespace GoClimb.Admin.Model.Facades
{

	import HttpService = GoClimb.Admin.Model.Http.HttpService;

	export class ArticlesFacade extends BaseFacade
	{
		public getArticles(callback: Function, errorCallback: Function = null)
		{
			this.httpService.requestGet('articles', callback, errorCallback);
		}

		public createArticle(article, publish: boolean, callback: Function, errorCallback: Function = null)
		{
			article = angular.copy(article);
			article.published = publish;
			this.httpService.requestPost('articles', {article}, callback, errorCallback);
		}

		public updateArticle(article, publish: boolean, callback: Function, errorCallback: Function = null)
		{
			article = angular.copy(article);
			article.published = publish;
			this.httpService.requestPost('articles/' + article.id, {article}, callback, errorCallback);
		}

		public deleteArticle(article, callback: Function, errorCallback: Function = null)
		{
			this.httpService.requestDelete('articles/' + article.id, {}, callback, errorCallback);
		}
	}

	ArticlesFacade.register(angular, 'articlesFacade', ['httpService']);

}
