namespace GoClimb.Admin.Model.Facades
{
	export class ColorsFacade extends BaseFacade
	{
		protected colors = [
			'#2ecc71',
			'#3498db',
			'#2c3e50',
			'#c0392b',
			'#8e44ad',
			'#95a5a6',
		];

		public getColors(callback: (colors: string[]) => void = null)
		{
		 	callback(this.colors);
		}
	}

	ColorsFacade.register(angular, 'colorsFacade', ['httpService']);

}
