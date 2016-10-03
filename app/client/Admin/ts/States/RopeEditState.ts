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

	export class RopeEditState extends BasePanelState
	{

		public url = '/edit/{id}';
		public templateUrl = 'app/client/Admin/ts/templates/Ropes/edit.html';
		public resolve = {
			rope: ['$stateParams', 'ropesFacade', '$state', ($stateParams, ropesFacade: RopesFacade, $state: IStateService) => {
				return new Promise((resolve, reject) => {
					ropesFacade.getRope($stateParams.id, (rope: IRope) => {
						if (rope) {
							resolve(angular.copy(rope));
						} else {
							reject();
							$state.go('404');
						}
					});
				});
			}],
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


		public controller = ['$scope', 'rope', 'sectors', 'parameters', 'ropesFacade', 'sectorsFacade', 'flashMessageSender',
			($scope, rope: IRope, sectors: ISector[], parameters, ropesFacade: RopesFacade, sectorsFacade: SectorsFacade, flashMessageSender: FlashMessageSender) => {

			this.data.canLeave = () => {
				return !($scope.ropeForm && $scope.ropeForm.$dirty);
			};

			this.updateRope(rope, sectors);

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

				ropesFacade.updateRope($scope.rope, (rope: IRope) => {
					$scope.saving = false;
					flashMessageSender.sendSuccess('flashes.routes.rope.updated.success');
					$scope.rope = rope;
					this.updateRope(rope, sectors);
					$scope.ropeForm.$setPristine();
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

		private updateRope(rope: IRope, sectors: ISector[])
		{
			for (var k in sectors) {
				if (sectors[k].id == rope.sector.id) {
					rope.sector = sectors[k];
					for (var l in sectors[k].lines) {
						if (sectors[k].lines[l].id == rope.line.id) {
							rope.line = sectors[k].lines[l];
							break;
						}
					}
					break;
				}
			}
		}

	}

	RopeEditState.register(angular, 'ropes.edit');

}
