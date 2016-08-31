namespace GoClimb.Admin.Model.Facades
{

    import HttpService = GoClimb.Admin.Model.Http.HttpService;

    export class NewsFacade extends BaseFacade
    {
        public getNews(callback: Function, errorCallback: Function = null)
        {
            this.httpService.get('news/', callback, errorCallback);
        }

        public createCurrentNews(currentNews, publish: boolean, callback: Function, errorCallback: Function = null)
        {
            currentNews = angular.copy(currentNews);
            currentNews.published = publish;
            this.httpService.post('news/', {currentNews}, callback, errorCallback);
        }

        public updateCurrentNews(currentNews, publish: boolean, callback: Function, errorCallback: Function = null)
        {
            currentNews = angular.copy(currentNews);
            currentNews.published = publish;
            var url : string = 'news/default/' + currentNews.id;
            this.httpService.post(url, {currentNews}, callback, errorCallback);
        }

        public deleteCurrentNews(currentNews, callback: Function, errorCallback: Function = null)
        {
            var url: string = 'news/default/' + currentNews.id;
            this.httpService.delete(url, {}, callback, errorCallback);
        }
    }

    NewsFacade.register(angular, 'newsFacade', ['httpService']);

}
