namespace GoClimb.Core.Plugins.OpeningHours
{

	export class OpeningHoursPlugin implements IPlugin
	{

		public getName(): string
		{
			return 'openingHours';
		}

	}

	PluginManager.registerPlugin(angular, new OpeningHoursPlugin);

}
