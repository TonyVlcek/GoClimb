namespace GoClimb.Admin.Model.Facades
{

	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import IBoulder = GoClimb.Admin.Model.Entities.IBoulder;
	import Utils = GoClimb.Core.Utils.Utils;

	export class BouldersFacade extends BaseFacade
	{

		private boulders: IndexedArray<IBoulder> = null;
		private loading = false;

		public getBoulders(callback: (boulders: IndexedArray<IBoulder>) => void = null, errorCallback: Function = null)
		{
			if (this.boulders === null && this.loading === false) {
				this.loading = true;
				this.httpService.requestGet('boulders/', (data) => {
					for (var id in data.boulders) {
						data.boulders[id] = BouldersFacade.mapBoulder(data.boulders[id]);
					}
					this.boulders = new IndexedArray<IBoulder>(data.boulders);
					this.loading = false;
					if (callback) {
						callback(this.boulders);
					}
				}, errorCallback);
			} else if (this.boulders) {
				callback(this.boulders);
			}
		}


		public getBoulder(id: number, callback: (boulder: IBoulder) => void = null, errorCallback: Function = null)
		{
			this.getBoulders((boulders: IndexedArray<IBoulder>) => {
				if (callback) {
					callback(boulders.getIndex(id.toString()));
				}
			}, errorCallback);
		}


		public createBoulder(boulder: IBoulder, callback: (boulder: IBoulder) => void = null, errorCallback: Function = null)
		{
			boulder = BouldersFacade.boulderToJson(angular.copy(boulder));
			this.httpService.requestPost('boulders/', {boulder: boulder}, (data) => {
				this.boulders.setIndex(data.boulder.id.toString(), BouldersFacade.mapBoulder(data.boulder));
				if (callback) {
					callback(this.boulders.getIndex(data.boulder.id.toString()));
				}
			}, errorCallback);
		}


		public updateBoulder(boulder: IBoulder, callback: (boulder: IBoulder) => void = null, errorCallback: Function = null)
		{
			boulder = BouldersFacade.boulderToJson(angular.copy(boulder));
			this.httpService.requestPost('boulders/' + boulder.id, {boulder: boulder}, (data) => {
				this.boulders.setIndex(data.boulder.id.toString(), BouldersFacade.mapBoulder(data.boulder));
				if (callback) {
					callback(this.boulders.getIndex(data.boulder.id.toString()));
				}
			}, errorCallback);
		}

		public deleteBoulder(boulder: IBoulder, callback: () => void, errorCallback: Function = null)
		{
			this.httpService.requestDelete('boulders/' + boulder.id, {}, () => {
				this.boulders.removeIndex(boulder.id.toString());
				if (callback) {
					callback();
				}
			}, errorCallback);
		}


		private static mapBoulder(boulder: IBoulder): IBoulder
		{
			if (boulder.dateCreated) {
				boulder.dateCreated = Utils.stringToDate(boulder.dateCreated);
			}
			if (boulder.dateRemoved) {
				boulder.dateRemoved = Utils.stringToDate(boulder.dateRemoved);
			}

			return boulder;
		}


		private static boulderToJson(boulder: IBoulder): IBoulder
		{
			if (boulder.dateCreated) {
				boulder.dateCreated = Utils.dateToString(boulder.dateCreated);
			}
			if (boulder.dateRemoved) {
				boulder.dateRemoved = Utils.dateToString(boulder.dateRemoved);
			}

			return boulder;
		}
	}

	BouldersFacade.register(angular, 'bouldersFacade', ['httpService']);

}
