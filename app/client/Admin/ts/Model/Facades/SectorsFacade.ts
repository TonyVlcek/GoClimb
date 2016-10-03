namespace GoClimb.Admin.Model.Facades
{

	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import ISector = GoClimb.Admin.Model.Entities.ISector;
	import ILine = GoClimb.Admin.Model.Entities.ILine;
	export class SectorsFacade extends BaseFacade
	{

		private loading: boolean = false;
		private sectors: IndexedArray<ISector> = null;

		public getSectors(callback: (sectors: IndexedArray<ISector>) => void, errorCallback: Function = null)
		{
			if (!this.loading && !this.sectors) {
				this.httpService.requestGet('sectors/', (data) => {
					this.sectors = new IndexedArray<ISector>(data.sectors);
					callback(this.sectors);
				}, {}, errorCallback);
			} else if (this.sectors) {
				callback(this.sectors);
			}
		}


		public createSector(name: string, callback: (sector: ISector) => void, errorCallback: Function = null)
		{
			this.httpService.requestPost('sectors/', {sector: {
				name: name
			}}, (data) => {
				this.sectors.setIndex(data.sector.id, data.sector);
				callback(data.sector);
			}, errorCallback);
		}


		public createLine(name: string, sector: ISector, callback: (line: ILine) => void, errorCallback: Function = null)
		{
			this.httpService.requestPost('sectors/' + sector.id + '/lines', {line: {
				name: name
			}}, (data) => {
				this.sectors.getIndex(sector.id.toString()).lines.push(data.line);
				callback(data.line);
			}, errorCallback);
		}

	}

	SectorsFacade.register(angular, 'sectorsFacade', ['httpService']);

}
