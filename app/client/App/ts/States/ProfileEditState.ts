namespace GoClimb.App.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import IStateService = angular.ui.IStateService;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import StylesFacade = GoClimb.Core.Model.Facades.StylesFacade;
	import ILog = GoClimb.Core.Model.Entities.ILog;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import LogsFacade = GoClimb.Core.Model.Facades.LogsFacade;
	import BouldersFacade = GoClimb.Core.Model.Facades.BouldersFacade;
	import RopesFacade = GoClimb.Core.Model.Facades.RopesFacade;
	import UserFacade = GoClimb.Core.Model.Facades.UserFacade;
	import IUser = GoClimb.Core.Model.Entities.IUser;
	import UserService = GoClimb.Admin.Services.UserService;

	export class ProfileEditState extends BasePanelState
	{

		public url = '/edit';
		public templateUrl = 'app/client/App/ts/templates/Profile/edit.html';
		public resolve = {
			userFromFacade: ['userService', (userService: UserService) => {
				return new Promise((resolve, reject) => {
					userService.getUser((user) => {
						resolve(angular.copy(user));
					});
				});
			}]
		};

		public controller = ['$scope', '$state', 'flashMessageSender', 'userFacade', 'userFromFacade', ($scope, $state: IStateService, flashMessageSender: FlashMessageSender, userFacade: UserFacade, userFromFacade) => {
			this.data.canLeave = () => {
				return !($scope.userForm && $scope.userForm.$dirty);
			};

			$scope.saving = false;
			$scope.user = userFromFacade;

			$scope.save = () => {
				if ($scope.userForm.$invalid) {
					flashMessageSender.sendError('flashes.user.error.invalidForm');
					return;
				}

				$scope.saving = true;
				userFacade.updateUser($scope.user, (user: IUser) => {
					$scope.userForm.$setPristine();
					$scope.saving = false;
					flashMessageSender.sendSuccess('flashes.user.saved');
					$state.go('^');
				});
			};
		}];

	}

	ProfileEditState.register(angular, 'profile.edit');

}
