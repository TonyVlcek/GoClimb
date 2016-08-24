namespace GoClimb.Admin.Model.Facades
{

	import HttpService = GoClimb.Admin.Model.Http.HttpService;

	export class ArticlesFacade extends BaseFacade
	{
		public getArticles(callback: Function, errorCallback: Function = null)
		{
			this.httpService.get('articles/', callback, errorCallback);
		}

		public createArticle(article, publish: boolean, callback: Function, errorCallback: Function = null)
		{
			article = angular.copy(article);
			article.published = publish;
			this.httpService.post('articles/', {article}, callback, errorCallback);
		}

		public updateArticle(article, publish: boolean, callback: Function, errorCallback: Function = null)
		{
			article = angular.copy(article);
			article.published = publish;
			var url : string = 'articles/default/' + article.id;
			this.httpService.post(url, {article}, callback, errorCallback);
		}

		public deleteArticle(article, callback: Function, errorCallback: Function = null)
		{
			var url: string = 'articles/default/' + article.id;
			this.httpService.delete(url, {}, callback, errorCallback);
		}
	}

	ArticlesFacade.register(angular, 'articlesFacade', ['httpService']);

}
