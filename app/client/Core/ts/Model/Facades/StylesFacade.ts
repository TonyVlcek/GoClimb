namespace GoClimb.Core.Model.Facades
{

	import IStyle = GoClimb.Core.Model.Entities.IStyle;

	export class StylesFacade extends BaseFacade
	{

		private loading: boolean = false;
		private styles: IStyle[] = null;

		public getStyles(callback: (styles: IStyle[]) => void = null)
		{
			if (!this.styles && !this.loading) {
				this.loading = true;
				this.httpService.requestGet('styles/', (data) => {
					this.styles = data.styles;
					callback(this.styles);
				});
			} else if (this.styles) {
				callback(this.styles);
			}
		}

	}

	StylesFacade.register(angular, 'stylesFacade', ['httpService']);

}
