namespace GoClimb.Admin.Model.Facades
{

	import IParameter = GoClimb.Admin.Model.Entities.IParameter;

	export class ParametersFacade extends BaseFacade
	{

		private loading: boolean = false;
		private parameters: IParameter[] = null;

		public getParameters(callback: (parameters: IParameter[]) => void = null)
		{
			if (!this.parameters && !this.loading) {
				this.loading = true;
				this.httpService.requestGet('parameters/', (data) => {
					this.parameters = data.parameters;
					callback(this.parameters);
				});
			} else if (this.parameters) {
				callback(this.parameters);
			}
		}

	}

	ParametersFacade.register(angular, 'parametersFacade', ['httpService']);

}
