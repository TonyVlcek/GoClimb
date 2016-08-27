namespace GoClimb.Admin.Controllers
{

    import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
    import PanelSize = GoClimb.Admin.Services.PanelSize;
    import NewsFacade = GoClimb.Admin.Model.Facades.NewsFacade;
    import DialogService = GoClimb.Admin.Services.DialogService;
    import IndexedArray = GoClimb.Core.Utils.IndexedArray;
    import PanelFactory = GoClimb.Admin.Services.PanelFactory;
    import Panel = GoClimb.Admin.Services.Panel;


    export class NewsController extends BaseAdminController
    {
        public panel: Panel;
        public newCurrentNews: boolean;
        public currentNewsForm: ng.IFormController;

        public processingSave: boolean = false;
        public processingSaveAsDraft: boolean = false;
        public processingDelete: boolean = false;

        public news: IndexedArray = null;
        public currentNews: any = null;

        private areNewsLoading: boolean = false;

        private flashMessageSender: FlashMessageSender;
        private newsFacade: NewsFacade;
        private $window: ng.IWindowService;
        private dialogService: DialogService;


        public constructor(panelFactory: PanelFactory, flashMessageSender: FlashMessageSender, newsFacade: NewsFacade, $window, dialogService)
        {
            super();
            this.flashMessageSender = flashMessageSender;
            this.newsFacade = newsFacade;
            this.$window = $window;
            this.dialogService = dialogService;

            this.panel = panelFactory.create('sidebar', true, PanelSize.EXPAND);
        }


        public openCreatePanel()
        {
            if (this.currentNewsForm.$dirty && !this.panel.confirmClose()) {
                return;
            }

            this.newCurrentNews = true;
            this.currentNewsForm.$setPristine();
            this.reset();

            this.stopProcessing();
            this.panel.open();
        }


        public openEditPanel(currentNews: Object)
        {
            if (this.currentNewsForm.$dirty && !this.panel.confirmClose()) {
                return;
            }

            this.newCurrentNews = false;
            this.currentNewsForm.$setPristine();
            this.reset();

            this.currentNews = angular.copy(currentNews);
            this.stopProcessing();
            this.panel.open();
        }


        public closePanel()
        {
            if (this.currentNewsForm.$dirty) {
                this.panel.close('confirm');
            }else{
                this.panel.close('done');
            }
        }


        public saveCurrentNews(publish: boolean)
        {
            if (this.currentNewsForm.$invalid) {
                this.flashMessageSender.sendError('flashes.news.error.invalidForm');
                return;
            }

            var message: string;
            if (!publish) {
                this.processingSaveAsDraft = true;
                message = 'flashes.news.savedAsDraft';
            } else if (this.currentNews.published && publish) {
                this.processingSave = true;
                message = 'flashes.news.saved';
            } else {
                this.processingSave = true;
                message = 'flashes.news.savedAndPublished';
            }

            var that = this;
            var callback = function (data) {
                that.saveCallback(data, message);
            };
            if (that.newCurrentNews) {
                this.newsFacade.createCurrentNews(this.currentNews, publish, callback);
            } else {
                this.newsFacade.updateCurrentNews(this.currentNews, publish, callback);
            }
        }


        public deleteCurrentNews()
        {
            if (!this.dialogService.confirm('flashes.news.delete')) {
                return;
            }

            this.processingDelete = true;
            var that = this;
            this.newsFacade.deleteCurrentNews(this.currentNews, function (data) {
                that.news.removeIndex(that.currentNews.id);
                that.stopProcessing();
                that.flashMessageSender.sendSuccess('flashes.news.deleted.success');
                that.panel.close('done');
                that.reset();
            });
        }


        public getNews() : IndexedArray
        {
            var that = this;
            if (this.areNewsLoading === false) {
                this.areNewsLoading = true;
                this.newsFacade.getNews(function (data) {
                    that.news = new IndexedArray(data.news);
                });
            }
            return this.news;
        }


        public isProcessing(): boolean
        {
            return this.processingDelete || this.processingSave || this.processingSaveAsDraft;
        }


        private saveCallback(data, message : string)
        {
            this.currentNews = angular.copy(data.currentNews);
            this.news.setIndex(data.currentNews.id, data.currentNews);
            if (this.newCurrentNews) {
                this.newCurrentNews = false;
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
            this.currentNews = {
                'name': null,
                'content': null
            };
        }

    }

    NewsController.register(angular, 'NewsController', ['panelFactory', 'flashMessageSender', 'newsFacade', '$window', 'DialogService']);

}
