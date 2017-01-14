namespace GoClimb.Admin.States
{

	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import WallDetailsFacade = GoClimb.Core.Model.Facades.WallDetailsFacade;
	import IWallDetails = GoClimb.Core.Model.Entities.IWallDetails;

	export class AnalyticsSettingsState extends BasePanelState
	{

		public url = '/analytics';
		public templateUrl = 'app/client/Admin/ts/templates/Settings/analyticsSettings.html';

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
				return !($scope.analyticsForm && $scope.analyticsForm.$dirty);
			};

			$scope.processingSave = false;
			$scope.analytics = settings;

			$scope.save = () => {
				if ($scope.analyticsForm.$invalid) {
					flashMessageSender.sendError('flashes.settings.error.invalidForm');
					return;
				}

				$scope.processingSave = true;
				var message = 'flashes.settings.updatedAnalytics';

				wallDetailsFacade.updateDetails($scope.analytics.details, (settings: IWallDetails) => {
					$scope.analytics = settings;
					$scope.analyticsForm.$setPristine();
					$scope.processingSave = false;
					flashMessageSender.sendSuccess(message);
				});
			};

			$scope.isProcessing = () => {
				return $scope.processingSave;
			};

		}];

	}

	AnalyticsSettingsState.register(angular, 'settings.analytics');

}
