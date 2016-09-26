namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import Authorizator = GoClimb.Admin.Services.Authorizator;

	export class NewsState extends BaseState
	{

		public url = '/news';
		public templateUrl = 'app/client/Admin/ts/templates/News/default.html';
		public controller = 'NewsController as newsCtrl';

		public onEnter = ['authorizator', (authorizator: Authorizator) => {

			return authorizator.isAllowed('admin.news');

		}];

	}

	NewsState.register(angular, 'news');

}
