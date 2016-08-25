namespace GoClimb.Core.Plugins
{

	export class PluginDefinition
	{

		public enabled: boolean;
		private plugin: IPlugin;


		public constructor(plugin: IPlugin, enabled: boolean = true)
		{
			this.plugin = plugin;
			this.enabled = enabled;
		}


		public getPlugin()
		{
			return this.plugin;
		}


	}

}
