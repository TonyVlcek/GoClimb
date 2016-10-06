namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import RolesFacade = GoClimb.Core.Model.Facades.RolesFacade;
	import IRole = GoClimb.Core.Model.Entities.IRole;
	import UserFacade = GoClimb.Core.Model.Facades.UserFacade;
	import DialogService = GoClimb.Admin.Services.DialogService;

	export class RoleManageUsersState extends BasePanelState
	{

		public url = '/role/{id}/users';
		public templateUrl = 'app/client/Admin/ts/templates/Roles/manageUsers.html';
		public resolve = {
			role: ['$stateParams', 'rolesFacade', ($stateParams, rolesFacade: RolesFacade) => {
				return new Promise((resolve, reject) => {
					rolesFacade.getRole($stateParams.id.toString(), function (role) {
						resolve(angular.copy(role));
					});
				});
			}]
		};

		private unlinkProcessing: number;

		public controller = ['$scope', 'role', 'rolesFacade', 'userFacade', 'flashMessageSender', 'dialogService', ($scope, role, rolesFacade: RolesFacade, userFacade: UserFacade, flashMessageSender: FlashMessageSender, dialogService: DialogService) => {
			this.data.canLeave = () => {
				return !($scope.linkUpUserForm && $scope.linkUpUserForm.$dirty);
			};

			$scope.role = role;

			$scope.save = () => {
				if ($scope.linkUpUserForm.$invalid) {
					flashMessageSender.sendError('flashes.roles.error.invalidForm');
					return;
				}


				$scope.processingSave = true;
				userFacade.getByEmail($scope.newUser.email, (user) => {
					if (!user) {
						$scope.linkUpUserForm.$setPristine();
						$scope.processingSave = false;
						flashMessageSender.sendError('flashes.roles.userNotFound');
					} else {
						rolesFacade.linkUpUser($scope.role.id, user.id, (role: IRole) => {
							$scope.newUser.email = '';
							$scope.linkUpUserForm.$setPristine();
							$scope.processingSave = false;
							$scope.role = role;
							flashMessageSender.sendSuccess('flashes.roles.userLinkedUp');
						});
					}
				});

			};

			$scope.unlink = (userId) => {
				if (!dialogService.confirm('flashes.roles.unlink')) {
					return;
				}

				this.unlinkProcessing = userId;
				rolesFacade.unlinkUser($scope.role.id, userId, (role) => {
					this.unlinkProcessing = null;
					$scope.role = role;
					flashMessageSender.sendSuccess('flashes.roles.userUnlinked');
				});

			};

			$scope.isUnlinkProcessing = (userId) => {
				return this.unlinkProcessing === userId;
			};
		}];

	}

	RoleManageUsersState.register(angular, 'roles.manageUsers');

}
