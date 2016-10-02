namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import RopesFacade = GoClimb.Admin.Model.Facades.RopesFacade;
	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
	import IStateService = angular.ui.IStateService;
	import IRope = GoClimb.Admin.Model.Entities.IRope;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import SectorsFacade = GoClimb.Admin.Model.Facades.SectorsFacade;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import ISector = GoClimb.Admin.Model.Entities.ISector;
	import ILine = GoClimb.Admin.Model.Entities.ILine;
	import ITranslateService = angular.translate.ITranslateService;
	import ParametersFacade = GoClimb.Admin.Model.Facades.ParametersFacade;

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
		};


		public controller = ['$scope', 'rope', 'sectors', 'parameters', 'ropesFacade', 'sectorsFacade', 'flashMessageSender', '$state',
			($scope, rope, sectors, parameters, ropesFacade: RopesFacade, sectorsFacade: SectorsFacade, flashMessageSender: FlashMessageSender, $state: IStateService) => {

			this.data.canLeave = () => {
				return !($scope.ropeForm && $scope.ropeForm.$dirty);
			};

			$scope.parameters = parameters;
			$scope.saving = false;
			$scope.rope = rope;
			$scope.sectors = sectors;
			$scope.newSector = null;
			$scope.sectorSaving = false;
			$scope.newLine = null;
			$scope.lineSaving = false;

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

			$scope.removeParameter = (index) => {
				$scope.rope.parameters.splice(index, 1);
			};

		}];

	}

	RopeCreateState.register(angular, 'ropes.create');

}
