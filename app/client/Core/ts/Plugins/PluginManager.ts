namespace GoClimb.Core.Plugins
{

	import IAngularStatic = angular.IAngularStatic;
	import BaseService = GoClimb.Core.Services.BaseService;

	export class PluginManager extends BaseService
	{

		private plugins: {[name: string]: PluginDefinition;} = {};


		public getPlugin(name: string): IPlugin
		{
			return name in this.plugins ? this.plugins[name].getPlugin() : null;
		}


		public getPluginDefinitions(): {[name: string]: PluginDefinition;}
		{
			return this.plugins;
		}


		public addPlugin(plugin: IPlugin): PluginManager
		{
			this.plugins[plugin.getName()] = new PluginDefinition(plugin);
			return this;
		}


		public static registerPlugin(angular: IAngularStatic, plugin: IPlugin)
		{
			angular.module('GoClimb').run(['pluginManager', function (pluginManager: PluginManager) {
				pluginManager.addPlugin(plugin);
			}]);
		}

	}

	PluginManager.register(angular, 'pluginManager');

}
