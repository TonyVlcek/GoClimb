namespace GoClimb.Admin.States
{

	import BaseState = GoClimb.Core.States.BaseState;
	import BouldersFacade = GoClimb.Core.Model.Facades.BouldersFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import IBoulder = GoClimb.Core.Model.Entities.IBoulder;
	import BasePanelState = GoClimb.Core.States.BasePanelState;
	import SectorsFacade = GoClimb.Core.Model.Facades.SectorsFacade;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import ISector = GoClimb.Core.Model.Entities.ISector;
	import ILine = GoClimb.Core.Model.Entities.ILine;
	import ITranslateService = angular.translate.ITranslateService;
	import ParametersFacade = GoClimb.Core.Model.Facades.ParametersFacade;
	import IStateService = angular.ui.IStateService;

	export class BoulderEditState extends BasePanelState
	{

		public url = '/edit/{id}';
		public templateUrl = 'app/client/Admin/ts/templates/Boulders/edit.html';
		public resolve = {
			boulder: ['$stateParams', 'bouldersFacade', '$state', ($stateParams, bouldersFacade: BouldersFacade, $state: IStateService) => {
				return new Promise((resolve, reject) => {
					bouldersFacade.getBoulder($stateParams.id, (boulder: IBoulder) => {
						if (boulder) {
							resolve(angular.copy(boulder));
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
		};


		public controller = ['$scope', 'boulder', 'sectors', 'bouldersFacade', 'sectorsFacade', 'flashMessageSender',
			($scope, boulder: IBoulder, sectors: ISector[], bouldersFacade: BouldersFacade, sectorsFacade: SectorsFacade, flashMessageSender: FlashMessageSender) => {

			this.data.canLeave = () => {
				return !($scope.boulderForm && $scope.boulderForm.$dirty);
			};

			this.updateBoulder(boulder, sectors);

			$scope.saving = false;
			$scope.boulder = boulder;
			$scope.sectors = sectors;
			$scope.newSector = null;
			$scope.sectorSaving = false;
			$scope.newLine = null;
			$scope.lineSaving = false;

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

				bouldersFacade.updateBoulder($scope.boulder, (boulder: IBoulder) => {
					$scope.saving = false;
					flashMessageSender.sendSuccess('flashes.routes.boulder.updated.success');
					$scope.boulder = boulder;
					this.updateBoulder(boulder, sectors);
					$scope.boulderForm.$setPristine();
				});
			};

		}];

		private updateBoulder(boulder: IBoulder, sectors: ISector[])
		{
			for (var k in sectors) {
				if (sectors[k].id == boulder.sector.id) {
					boulder.sector = sectors[k];
					for (var l in sectors[k].lines) {
						if (sectors[k].lines[l].id == boulder.line.id) {
							boulder.line = sectors[k].lines[l];
							break;
						}
					}
					break;
				}
			}
		}

	}

	BoulderEditState.register(angular, 'boulders.edit');

}
