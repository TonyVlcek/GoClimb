namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;
	import IScope = angular.IScope;
	import ColorsFacade = GoClimb.Core.Model.Facades.ColorsFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import DifficultyFacade = GoClimb.Core.Model.Facades.DifficultyFacade;
	import IDifficulty = GoClimb.Core.Model.Entities.IDifficulty;

	export class DifficultyPickerDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Admin/ts/Directives/DifficultyPicker/DifficultyPickerDirective.html';

		public scope = {
			difficulty: '=difficultyPicker',
			type: '=type'
		};

		private difficultyFacade: DifficultyFacade;
		private type: string;

		public constructor(difficultyFacade: DifficultyFacade)
		{
			super();
			this.difficultyFacade = difficultyFacade;
		}

		public link = (scope) =>
		{
			if (scope.difficulty) {
				scope.difficulties = [{
					id: scope.difficulty.id,
					label: this.getLabel(scope.difficulty)
				}];
			}
			this.type = scope.type;
			this.difficultyFacade.getDifficulties((difficulties: IDifficulty[]) => {
				var result = [];
				for (var k in difficulties) {
					var difficulty: IDifficulty = difficulties[k];
					if (difficulty.UIAA && this.type === 'rope' || difficulty.HUECO && this.type === 'boulder') {
						result.push({
							id: difficulty.id,
							label: this.getLabel(difficulty)
						});
					}
				}
				scope.difficulties = result;
			});
		};


		private getLabel = (difficulty: IDifficulty) =>
		{
			return (this.type === 'rope' ? (difficulty.UIAA + ' | ' + difficulty.FRL) : (difficulty.HUECO + ' | ' + difficulty.FRB)) + ' (' + difficulty.points + ')';
		};
	}

	DifficultyPickerDirective.register(angular, 'difficultyPicker', ['difficultyFacade']);

}
