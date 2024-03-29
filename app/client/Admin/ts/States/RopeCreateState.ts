namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import RopesFacade = GoClimb.Core.Model.Facades.RopesFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import IRope = GoClimb.Core.Model.Entities.IRope;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import SectorsFacade = GoClimb.Core.Model.Facades.SectorsFacade;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import ISector = GoClimb.Core.Model.Entities.ISector;
	import ILine = GoClimb.Core.Model.Entities.ILine;
	import ITranslateService = angular.translate.ITranslateService;
	import ParametersFacade = GoClimb.Core.Model.Facades.ParametersFacade;
	import RolesFacade = GoClimb.Core.Model.Facades.RolesFacade;
	import IUser = GoClimb.Core.Model.Entities.IUser;
	import UserFacade = GoClimb.Core.Model.Facades.UserFacade;
	import Utils = GoClimb.Core.Utils.Utils;
	import UserService = GoClimb.Admin.Services.UserService;

	export class RopeCreateState extends BasePanelState
	{

		public url = '/create';
		public templateUrl = 'app/client/Admin/ts/templates/Ropes/create.html';
		public resolve = {
			rope: (): IRope => {
				return {
					line: null,
					sector: null,
					name: null,
					description: null,
					dateCreated: null,
					dateRemoved: null,
					difficulty: null,
					colors: [],
					length: null,
					steps: null,
					parameters: [],
				}
			},
			sectors: ['sectorsFacade', (sectorsFacade: SectorsFacade) => {
				return new Promise((resolve) => {
					sectorsFacade.getSectors((sectors) => {
						resolve(sectors.getAsArray());
					});
				});
			}],
			parameters: ['parametersFacade', (parametersFacade: ParametersFacade) => {
				return new Promise((resolve) => {
					parametersFacade.getParameters((parameters) => {
						resolve(parameters);
					})
				})
			}],
			builders: ['rolesFacade', (rolesFacade: RolesFacade) => {
				return new Promise((resolve) => {
					rolesFacade.getBuilders((users) => {
						resolve(users);
					});
				})
			}],
		};


		public controller = ['$scope', 'rope', 'sectors', 'parameters', 'builders', 'ropesFacade', 'sectorsFacade', 'flashMessageSender', '$state', 'userService',
			($scope, rope, sectors, parameters, builders, ropesFacade: RopesFacade, sectorsFacade: SectorsFacade, flashMessageSender: FlashMessageSender, $state: IStateService, userService: UserService) => {

			this.data.canLeave = () => {
				return !($scope.ropeForm && $scope.ropeForm.$dirty);
			};

			$scope.builders = builders;
			$scope.parameters = angular.copy(parameters);
			$scope.saving = false;
			$scope.rope = rope;
			$scope.sectors = sectors;
			$scope.newSector = null;
			$scope.sectorSaving = false;
			$scope.newLine = null;
			$scope.lineSaving = false;

			//Probably should be in resolve section
			userService.getUser((user: IUser) => {
				$scope.rope.builder = {
					  'id': user.id,
					  'name': user.nick
				};
			});

			$scope.isSectorOk = () => {
				return $scope.rope.sector && $scope.rope.sector.id;
			};

			$scope.isLineOk = () => {
				return $scope.rope.line && $scope.rope.line.id;
			};

			$scope.saveSector = () => {
				$scope.sectorSaving = true;
				sectorsFacade.createSector($scope.newSector, (sector: ISector) => {
					$scope.newSector = null;
					$scope.sectorSaving = false;
					$scope.sectors.push(sector);
					$scope.rope.sector = sector;
					flashMessageSender.sendSuccess('flashes.routes.sector.created.success');
				});
			};

			$scope.saveLine = () => {
				$scope.lineSaving = true;
				sectorsFacade.createLine($scope.newLine, $scope.rope.sector, (line: ILine) => {
					$scope.newLine = null;
					$scope.lineSaving = false;
					$scope.rope.sector.lines.push(line);
					$scope.rope.line = line;
					flashMessageSender.sendSuccess('flashes.routes.line.created.success');
				});
			};

			$scope.displayRest = () => {
				return $scope.isLineOk() && $scope.isSectorOk();
			};

			$scope.save = () => {
				if ($scope.ropeForm.$invalid || !$scope.displayRest()) {
					flashMessageSender.sendError('flashes.routes.rope.error.invalidForm');
					return;
				}

				$scope.saving = true;

				ropesFacade.createRope($scope.rope, (rope: IRope) => {
					$scope.ropeForm.$setPristine();
					$scope.saving = false;
					flashMessageSender.sendSuccess('flashes.routes.rope.created.success');
					$state.go('ropes.edit', {id: rope.id});
				});
			};

			$scope.addParameter = () => {
				$scope.rope.parameters.push({
					parameter: null,
					level: null,
				});
			};

			$scope.updateParameterSelection = (name) => {
				for (var i in $scope.parameters) {
					if($scope.parameters[i].name == name){
						$scope.parameters[i].disabled = true;
					}
				}
			};

			$scope.removeParameter = (index) => {
				var name = $scope.rope.parameters[index].parameter;
				for (var i in $scope.parameters) {
					if($scope.parameters[i].name == name){
						$scope.parameters[i].disabled = false;
					}
				}
				$scope.rope.parameters.splice(index, 1);
			};

		}];

	}

	RopeCreateState.register(angular, 'ropes.create');

}
