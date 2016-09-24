namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;
	import IScope = angular.IScope;
	import ColorsFacade = GoClimb.Admin.Model.Facades.ColorsFacade;
	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;

	export class ColorPickerDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Admin/ts/Directives/ColorPicker/ColorPickerDirective.html';

		public scope = {
			selectedColors: '=colorPicker',
		};

		private colorsFacade: ColorsFacade;
		private flashMessageSender: FlashMessageSender;

		public constructor(colorsFacade: ColorsFacade, flashMessageSender: FlashMessageSender)
		{
			super();
			this.colorsFacade = colorsFacade;
			this.flashMessageSender = flashMessageSender;
		}

		public link = (scope) =>
		{
			if (scope.selectedColors === null) {
				scope.selectedColors = [];
			}

			this.colorsFacade.getColors((colors) => {
				scope.colors = colors;
				for (var key in scope.selectedColors) {
					if (scope.colors.indexOf(scope.selectedColors[key]) === -1) {
						scope.selectedColors.splice(key, 1);
					}
				}
			});


			scope.isColorActive = (color) => {
				return scope.selectedColors.indexOf(color) > -1;
			};

			scope.toggleColor = (color) => {
				if (scope.selectedColors.indexOf(color) > -1) {
					scope.selectedColors.splice(scope.selectedColors.indexOf(color), 1);
				} else if (scope.selectedColors.length < 3) {
					scope.selectedColors.push(color);
				} else {
					this.flashMessageSender.sendInfo('directives.colorPicker.max');
				}
			}
		};
	}

	ColorPickerDirective.register(angular, 'colorPicker', ['colorsFacade', 'flashMessageSender']);

}
