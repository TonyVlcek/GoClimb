namespace GoClimb.Core.Model.Entities
{

	export interface IUser
	{

		id?: number;
		nick: string;
		email: string
		firstName: string;
		lastName: string;
		height: number;
		weight: number;
		phone: number;
		birthDate?: any;
		climbingSince?: any;
		basic: boolean;
	}

}
