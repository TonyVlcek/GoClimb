namespace GoClimb.Core.Utils
{

	export class Utils
	{

		public static stringToDate(date: string): Date
		{
			return new Date(Date.parse(date));
		}

		public static dateToString(date: Date): string
		{
			return date.toISOString();
		}

	}
}
