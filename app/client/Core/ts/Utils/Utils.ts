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

		public static getQueryVariable(query: string, string: string)
		{
			query = query.substring(query.indexOf("?") + 1);
			var vars = query.split('&');
			for (var i = 0; i < vars.length; i++) {
				var pair = vars[i].split('=');
				if (decodeURIComponent(pair[0]) == string) {
					return decodeURIComponent(pair[1]);
				}
			}
			console.log('Query variable %s not found', string);
		}

	}
}
