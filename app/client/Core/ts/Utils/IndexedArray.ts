namespace GoClimb.Core.Utils
{
	export class IndexedArray
	{
		private data: {} = {};
		private arrayData: any[] = [];


		constructor(data: {})
		{
			this.setData(data);
		}

		public setData(value: {})
		{
			this.data = value;

			this.removeIndexes();
			return this;
		}

		public getAsObject(): {}
		{
			return this.data;
		}

		public getAsArray(): any[]
		{
			return this.arrayData;
		}

		public removeIndex(index: number): IndexedArray
		{
			delete this.data[index.toString()];
			this.removeIndexes();
			return this;
		}

		public setIndex(index: number, item: any): IndexedArray
		{
			this.data[index.toString()] = item;
			this.removeIndexes();
			return this;
		}

		public isEmpty(): boolean
		{
			return Object.keys(this.data).length === 0;
		}

		private removeIndexes()
		{
			var updateData: any[] = [];
			for (var index in this.data) {
				updateData.push(this.data[index]);
			}
			this.arrayData = updateData;
		}
	}

}
