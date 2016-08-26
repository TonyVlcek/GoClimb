namespace GoClimb.Core.Utils
{
	export class IndexedArray<T>
	{
		private data: {[key: string]: T} = {};
		private arrayData: T[] = [];


		constructor(data: {[key: string]: T})
		{
			this.setData(data);
		}

		public setData(value: {[key: string]: T})
		{
			this.data = {};
			for (var k in value) {
				this.data[k.toString()] = value[k];
			}

			this.removeIndexes();
			return this;
		}

		public getAsObject(): {[key: string]: T}
		{
			return this.data;
		}

		public getAsArray(): T[]
		{
			return this.arrayData;
		}

		public removeIndex(index: string): IndexedArray<T>
		{
			delete this.data[index.toString()];
			this.removeIndexes();
			return this;
		}

		public setIndex(index: string, item: T): IndexedArray<T>
		{
			this.data[index.toString()] = item;
			this.removeIndexes();
			return this;
		}

		public getIndex(index: string): T
		{
			return (index.toString() in this.data) ? this.data[index.toString()] : null;
		}

		public isEmpty(): boolean
		{
			return Object.keys(this.data).length === 0;
		}

		private removeIndexes()
		{
			this.arrayData = [];
			for (var index in this.data) {
				this.arrayData.push(this.data[index]);
			}
		}
	}

}
