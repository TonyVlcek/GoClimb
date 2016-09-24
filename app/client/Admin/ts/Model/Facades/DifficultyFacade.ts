namespace GoClimb.Admin.Model.Facades
{

	import IDifficulty = GoClimb.Admin.Model.Entities.IDifficulty;

	export class DifficultyFacade extends BaseFacade
	{

		private loading: boolean = false;
		private difficulties: IDifficulty[] = null;

		public getDifficulties(callback: (difficulties: IDifficulty[]) => void = null)
		{
			if (!this.difficulties && !this.loading) {
				this.loading = true;
				this.httpService.requestGet('difficulties/', (data) => {
					this.difficulties = data.difficulties;
					callback(this.difficulties);
				});
			} else if (this.difficulties) {
				callback(this.difficulties);
			}
		}

	}

	DifficultyFacade.register(angular, 'difficultyFacade', ['httpService']);

}
