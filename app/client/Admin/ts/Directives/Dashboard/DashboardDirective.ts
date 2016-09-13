namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;

	export class DashboardDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Admin/ts/Directives/Dashboard/DashboardDirective.html';

		private $state;
		private $translate;

		public constructor($state, $translate) {
			super();
			this.$state = $state;
			this.$translate = $translate;
		}

		public link = (scope) =>
		{
			var categories = [
				{
					name: 'directives.dashboard.article.title',
					links: [
						{
							name: 'directives.dashboard.article.items.list.title',
							href: 'articles',
							description: 'directives.dashboard.article.items.list.description'
						},
						{
							name: 'directives.dashboard.article.items.create.title',
							href: 'articles.create',
							description: 'directives.dashboard.article.items.create.description'
						}
					]
				},
				{
					name: 'directives.dashboard.news.title',
					links: [
						{
							name: 'directives.dashboard.news.items.list.title',
							href: 'news',
							description: 'directives.dashboard.news.items.list.description'
						},
						{
							name: 'directives.dashboard.news.items.create.title',
							href: 'news.create',
							description: 'directives.dashboard.news.items.create.description'
						}
					]
				},
				{
					name: 'directives.dashboard.events.title',
					links: [
						{
							name: 'directives.dashboard.events.items.list.title',
							href: 'events',
							description: 'directives.dashboard.events.items.list.description'
						},
						{
							name: 'directives.dashboard.events.items.create.title',
							href: 'events.create',
							description: 'directives.dashboard.events.items.create.description'
						}
					]
				},
				{
					name: 'directives.dashboard.roles.title',
					links: [
						{
							name: 'directives.dashboard.roles.items.list.title',
							href: 'roles',
							description: 'directives.dashboard.roles.items.list.description'
						}
					]
				},
				{
					name: 'directives.dashboard.settings.title',
					links: [
						{
							name: 'directives.dashboard.settings.items.list.title',
							href: 'settings',
							description: 'directives.dashboard.settings.items.list.description'
						},
						{
							name: 'directives.dashboard.settings.items.advanced.title',
							href: 'settings.advancedSettings',
							description: 'directives.dashboard.settings.items.advanced.description'
						}
					]
				}
			];

			scope.categories = [];

			for (var key in categories) {
				var category = {
					name: this.$translate.instant(categories[key].name),
					links: []
				};
				for (var key2 in categories[key].links) {
					category.links.push({
						name: this.$translate.instant(categories[key].links[key2].name),
						href: this.$translate.instant(categories[key].links[key2].href),
						description: this.$translate.instant(categories[key].links[key2].description)
					});
				}
				scope.categories.push(category);
			}

			scope.links = [];
			for (var key in scope.categories) {
				for (var key2 in scope.categories[key].links) {
					var link = scope.categories[key].links[key2];
					link.category = scope.categories[key].name;
					scope.links.push(link);
				}
			}

			scope.goTo = (link: string) => {
				this.$state.go(link);
			}
		}

	}

	DashboardDirective.register(angular, 'dashboard', ['$state', '$translate']);

}
