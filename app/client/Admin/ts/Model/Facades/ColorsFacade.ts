namespace GoClimb.Admin.Model.Facades
{
	export class ColorsFacade extends BaseFacade
	{

		private loading: boolean = false;
		private colors: string[] = null;

		public getColors(callback: (colors: string[]) => void = null)
		{
			if (!this.colors && !this.loading) {
				this.loading = true;
				this.httpService.requestGet('colors/', (data) => {
					this.colors = data.colors;
					callback(this.colors);
				});
			} else if (this.colors) {
				callback(this.colors);
			}
		}

	}

	ColorsFacade.register(angular, 'colorsFacade', ['httpService']);

}
