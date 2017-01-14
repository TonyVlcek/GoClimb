namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;
	import Authorizator = GoClimb.Admin.Services.Authorizator;
	import IApi = Foundation.IApi;

	export class DashboardDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Admin/ts/Directives/Dashboard/DashboardDirective.html';

		private $state;
		private $translate;
		private authorizator: Authorizator;
		private foundationApi: IApi;

		public constructor($state, $translate, authorizator: Authorizator, foundationApi: IApi) {
			super();
			this.$state = $state;
			this.$translate = $translate;
			this.authorizator = authorizator;
			this.foundationApi = foundationApi;
		}

		public link = (scope) =>
		{

			var categories = {
				content: {
					listArticles: {
						link: 'articles',
						permission: 'admin.articles',
					},
					createArticle: {
						link: 'articles.create',
						permission: 'admin.articles',
					},
					listNews: {
						link: 'news',
						permission: 'admin.news',
					},
					createNews: {
						link: 'news.create',
						permission: 'admin.news'
					},
					listEvents: {
						link: 'events',
						permission: 'admin.events',
					},
					createEvent: {
						link: 'events.create',
						permission: 'admin.events'
					},
				},
				routes: {
					ropeList: {
						link: 'ropes',
						permission: 'admin.routes.rope',
					},
					ropeCreate: {
						link: 'ropes.create',
						permission: 'admin.routes.rope',
					},
					boulderList: {
						link: 'boulders',
						permission: 'admin.routes.boulder',
					},
					boulderCreate: {
						link: 'boulders.create',
						permission: 'admin.routes.boulder',
					},
				},
				settings: {
					listRoles: {
						link: 'roles',
						permission: 'admin.acl',
					},
					listSettings: {
						link: 'settings',
						permission: 'admin.settings.advanced',
					},
					advancedSettings: {
						link: 'settings.advancedSettings',
						permission: 'admin.settings.advanced'
					},
					analyticsSettings: {
						link: 'settings.analytics',
						permission: 'admin.settings.advanced'
					},
				},
			};

			scope.categories = [];

			for (var key in categories) {
				var category = {
					name: this.$translate.instant('dashboard.' + key + '.title'),
					items: []
				};
				for (var key2 in categories[key]) {
					if (this.authorizator.isAllowed(categories[key][key2].permission)) {
						category.items.push({
							name: this.$translate.instant('dashboard.' + key + '.items.' + key2 + '.title'),
							link: categories[key][key2].link,
							description: this.$translate.instant('dashboard.' + key + '.items.' + key2 + '.description'),
							aliases: this.$translate.instant('dashboard.' + key + '.items.' + key2 + '.aliases'),
						});
					}
				}

				if (category.items.length) {
					scope.categories.push(category);
				}
			}

			scope.links = [];
			for (var key in scope.categories) {
				for (var key2 in scope.categories[key].items) {
					var item = scope.categories[key].items[key2];
					item.category = scope.categories[key].name;
					scope.links.push(item);
				}
			}

			scope.goTo = (link: string) => {
				var modal = $('.is-active[zf-closable]#action-modal');
				if (modal.length) {
					this.foundationApi.publish('action-modal', 'close');
				}
				this.$state.go(link);
			}
		}

	}

	DashboardDirective.register(angular, 'dashboard', ['$state', '$translate', 'authorizator', 'FoundationApi']);

}
