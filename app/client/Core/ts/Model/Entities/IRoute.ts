namespace GoClimb.Core.Model.Entities
{

	export interface IRoute
	{

		id?: number;
		builder?: {
			id: number;
			name: string;
		}
		line: {
			id?: number;
			name: string;
		};
		sector: {
			id?: number;
			name: string;
		};
		name: string;
		description?: string;
		dateCreated: any /*string|Date*/;
		dateRemoved: any /*string|Date*/;
		colors: string[];
		difficulty: IDifficulty;
		parameters: Array<{
			parameter: string;
			level: number;
		}>;

	}

}
