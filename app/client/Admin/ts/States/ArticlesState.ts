namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import Authorizator = GoClimb.Admin.Services.Authorizator;

	export class ArticlesState extends BaseState
	{

		public url = '/articles';
		public templateUrl = 'app/client/Admin/ts/templates/Articles/default.html';
		public controller = 'ArticlesController as articlesCtrl';

		public onEnter = ['authorizator', (authorizator: Authorizator) => {

			return authorizator.isAllowed('admin.articles');

		}];
	}

	ArticlesState.register(angular, 'articles');

}
