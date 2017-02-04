namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import BouldersFacade = GoClimb.Core.Model.Facades.BouldersFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import IBoulder = GoClimb.Core.Model.Entities.IBoulder;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import SectorsFacade = GoClimb.Core.Model.Facades.SectorsFacade;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import ISector = GoClimb.Core.Model.Entities.ISector;
	import ILine = GoClimb.Core.Model.Entities.ILine;
	import ITranslateService = angular.translate.ITranslateService;
	import ParametersFacade = GoClimb.Core.Model.Facades.ParametersFacade;
	import RolesFacade = GoClimb.Core.Model.Facades.RolesFacade;
	import IUser = GoClimb.Core.Model.Entities.IUser;
	import Utils = GoClimb.Core.Utils.Utils;
	import UserService = GoClimb.Admin.Services.UserService;

	export class BoulderCreateState extends BasePanelState
	{

		public url = '/create';
		public templateUrl = 'app/client/Admin/ts/templates/Boulders/create.html';
		public resolve = {
			boulder: (): IBoulder => {
				return {
					line: null,
					sector: null,
					name: null,
					description: null,
					dateCreated: null,
					dateRemoved: null,
					difficulty: null,
					colors: [],
					start: null,
					end: null,
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
			builders: ['rolesFacade', (rolesFacade: RolesFacade) => {
				return new Promise((resolve) => {
					rolesFacade.getBuilders((users) => {
						resolve(users);
					});
				})
			}],
		};


		public controller = ['$scope', 'boulder', 'sectors', 'builders', 'bouldersFacade', 'sectorsFacade', 'flashMessageSender', '$state', 'userService',
			($scope, boulder, sectors, builders, bouldersFacade: BouldersFacade, sectorsFacade: SectorsFacade, flashMessageSender: FlashMessageSender, $state: IStateService, userService: UserService) => {

			this.data.canLeave = () => {
				return !($scope.boulderForm && $scope.boulderForm.$dirty);
			};

			$scope.builders = builders;
			$scope.saving = false;
			$scope.boulder = boulder;
			$scope.sectors = sectors;
			$scope.newSector = null;
			$scope.sectorSaving = false;
			$scope.newLine = null;
			$scope.lineSaving = false;

			//Probably should be in resolve section
			userService.getUser((user: IUser) => {
				$scope.boulder.builder = {
					'id': user.id,
					'name': user.nick
				};
			});

			$scope.isSectorOk = () => {
				return $scope.boulder.sector && $scope.boulder.sector.id;
			};

			$scope.isLineOk = () => {
				return $scope.boulder.line && $scope.boulder.line.id;
			};

			$scope.saveSector = () => {
				$scope.sectorSaving = true;
				sectorsFacade.createSector($scope.newSector, (sector: ISector) => {
					$scope.newSector = null;
					$scope.sectorSaving = false;
					$scope.sectors.push(sector);
					$scope.boulder.sector = sector;
					flashMessageSender.sendSuccess('flashes.routes.sector.created.success');
				});
			};

			$scope.saveLine = () => {
				$scope.lineSaving = true;
				sectorsFacade.createLine($scope.newLine, $scope.boulder.sector, (line: ILine) => {
					$scope.newLine = null;
					$scope.lineSaving = false;
					$scope.boulder.sector.lines.push(line);
					$scope.boulder.line = line;
					flashMessageSender.sendSuccess('flashes.routes.line.created.success');
				});
			};

			$scope.displayRest = () => {
				return $scope.isLineOk() && $scope.isSectorOk();
			};

			$scope.save = () => {
				if ($scope.boulderForm.$invalid || !$scope.displayRest()) {
					flashMessageSender.sendError('flashes.routes.boulder.error.invalidForm');
					return;
				}

				$scope.saving = true;

				bouldersFacade.createBoulder($scope.boulder, (boulder: IBoulder) => {
					$scope.boulderForm.$setPristine();
					$scope.saving = false;
					flashMessageSender.sendSuccess('flashes.routes.boulder.created.success');
					$state.go('boulders.edit', {id: boulder.id});
				});
			};

		}];

	}

	BoulderCreateState.register(angular, 'boulders.create');

}
