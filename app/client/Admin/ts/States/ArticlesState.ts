namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;

	export class ArticlesState extends BaseState
	{

		public url = '/articles';
		public templateUrl = 'app/client/Admin/ts/templates/Articles/default.html';
		public controller = 'ArticlesController as articlesCtrl';

	}

	ArticlesState.register(angular, 'articles');

}
