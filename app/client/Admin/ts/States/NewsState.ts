namespace GoClimb.Admin.States
{

    import BaseState = GoClimb.Core.States.BaseState;

    export class NewsState extends BaseState
    {

        public url = '/news';
        public templateUrl = 'app/client/Admin/ts/templates/News/default.html';
        public controller = 'NewsController as newsCtrl';

    }

    NewsState.register(angular, 'news');

}
