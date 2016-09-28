namespace GoClimb.Admin.Model.Facades
{

	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import IRope = GoClimb.Admin.Model.Entities.IRope;
	import Utils = GoClimb.Core.Utils.Utils;

	export class RopesFacade extends BaseFacade
	{

		private ropes: IndexedArray<IRope> = null;
		private loading = false;

		public getRopes(callback: (ropes: IndexedArray<IRope>) => void = null, errorCallback: Function = null)
		{
			if (this.ropes === null && this.loading === false) {
				this.loading = true;
				this.httpService.requestGet('ropes/', (data) => {
					for (var id in data.ropes) {
						data.ropes[id] = RopesFacade.mapRope(data.ropes[id]);
					}
					this.ropes = new IndexedArray<IRope>(data.ropes);
					this.loading = false;
					if (callback) {
						callback(this.ropes);
					}
				}, {}, errorCallback);
			} else if (this.ropes) {
				callback(this.ropes);
			}
		}


		public getRope(id: number, callback: (rope: IRope) => void = null, errorCallback: Function = null)
		{
			this.getRopes((ropes: IndexedArray<IRope>) => {
				if (callback) {
					callback(ropes.getIndex(id.toString()));
				}
			}, errorCallback);
		}


		public createRope(rope: IRope, callback: (rope: IRope) => void = null, errorCallback: Function = null)
		{
			rope = RopesFacade.ropeToJson(angular.copy(rope));
			this.httpService.requestPost('ropes/', {rope: rope}, (data) => {
				this.ropes.setIndex(data.rope.id.toString(), RopesFacade.mapRope(data.rope));
				if (callback) {
					callback(this.ropes.getIndex(data.rope.id.toString()));
				}
			}, errorCallback);
		}


		public updateRope(rope: IRope, callback: (rope: IRope) => void = null, errorCallback: Function = null)
		{
			rope = RopesFacade.ropeToJson(angular.copy(rope));
			this.httpService.requestPost('ropes/' + rope.id, {rope: rope}, (data) => {
				this.ropes.setIndex(data.rope.id.toString(), RopesFacade.mapRope(data.rope));
				if (callback) {
					callback(this.ropes.getIndex(data.rope.id.toString()));
				}
			}, errorCallback);
		}

		public deleteRope(rope: IRope, callback: () => void, errorCallback: Function = null)
		{
			this.httpService.requestDelete('ropes/' + rope.id, {}, () => {
				this.ropes.removeIndex(rope.id.toString());
				if (callback) {
					callback();
				}
			}, errorCallback);
		}


		private static mapRope(rope: IRope): IRope
		{
			if (rope.dateCreated) {
				rope.dateCreated = Utils.stringToDate(rope.dateCreated);
			}
			if (rope.dateRemoved) {
				rope.dateRemoved = Utils.stringToDate(rope.dateRemoved);
			}

			return rope;
		}


		private static ropeToJson(rope: IRope): IRope
		{
			if (rope.dateCreated) {
				rope.dateCreated = Utils.dateToString(rope.dateCreated);
			}
			if (rope.dateRemoved) {
				rope.dateRemoved = Utils.dateToString(rope.dateRemoved);
			}

			return rope;
		}
	}

	RopesFacade.register(angular, 'ropesFacade', ['httpService']);

}
