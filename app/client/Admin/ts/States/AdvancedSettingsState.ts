namespace GoClimb.Admin.States
{

	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import WallDetailsFacade = GoClimb.Admin.Model.Facades.WallDetailsFacade;
	import IWallDetails = GoClimb.Admin.Model.Entities.IWallDetails;

	export class AdvancedSettingsState extends BasePanelState
	{

		public url = '/settings';
		public templateUrl = 'app/client/Admin/ts/templates/Settings/advancedSettings.html';

		public resolve = {
			settings: ['wallDetailsFacade', (wallDetailsFacade: WallDetailsFacade) => {
				return new Promise((resolve, reject) => {
					wallDetailsFacade.getDetails(function (settings) {
						resolve(angular.copy(settings));
					});
				});
			}]
		};

		public controller = ['$scope', 'settings', 'wallDetailsFacade', 'flashMessageSender', ($scope, settings, wallDetailsFacade: WallDetailsFacade, flashMessageSender: FlashMessageSender) => {
			this.data.canLeave = () => {
				return !($scope.advancedSettingsForm && $scope.advancedSettingsForm.$dirty);
			};

			$scope.processingSave = false;
			$scope.processingSaveAsDraft = false;
			$scope.advancedSettings = settings;

			$scope.save = () => {
				if ($scope.advancedSettingsForm.$invalid) {
					flashMessageSender.sendError('flashes.settings.error.invalidForm');
					return;
				}

				$scope.processingSave = true;
				var message = 'flashes.settings.updated';

				wallDetailsFacade.updateDetails($scope.advancedSettings.details, (settings: IWallDetails) => {
					$scope.advancedSettings = settings;
					$scope.advancedSettingsForm.$setPristine();
					$scope.processingSave = false;
					$scope.processingSaveAsDraft = false;
					flashMessageSender.sendSuccess(message);
				});
			};

			$scope.isProcessing = () => {
				return $scope.processingSave || $scope.processingSaveAsDraft;
			};

		}];

	}

	AdvancedSettingsState.register(angular, 'settings.advancedSettings');

}
