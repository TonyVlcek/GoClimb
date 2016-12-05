namespace GoClimb.Core.Model.Entities
{

	export interface ILog
	{

		id?: number;
		user?: {
			id: number;
			name: string;
		};
		wall?: {
			name: string;
		}
		style?: IStyle;
		route?: IRoute;
		loggedDate: any /*string|Date*/;
		description?: string;
		points?: number;

	}

}
