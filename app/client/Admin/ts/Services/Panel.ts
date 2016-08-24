namespace GoClimb.Admin.Services
{

	import IApi = Foundation.IApi;
	import IAugmentedJQuery = angular.IAugmentedJQuery;
	import BaseService = GoClimb.Core.Services.BaseService;
	import IWindowService = angular.IWindowService;
	import ITimeoutService = angular.ITimeoutService;
	import ScreenSize = GoClimb.Core.Utils.ScreenSize;

	export enum PanelSize {
		EXPAND,
		COMPRESS
	}

	export class Panel
	{
		//Fix for angular 1.x template
		public panelSizeEnum = PanelSize;

		private api: IApi;
		private $timeout;
		private $window: ng.IWindowService;
		private dialogService;

		private delay: number = 20;
		private size: PanelSize;
		private isOpen: boolean;
		private alwaysAnimateOpen: boolean;
		private allowCompressAt: ScreenSize;

		private id: string;

		public constructor($timeout: ITimeoutService, $window: IWindowService, api: IApi, dialogService: DialogService, panelId: string, alwaysAnimateOpen: boolean, size: PanelSize)
		{
			this.api = api;
			this.$timeout = $timeout;
			this.$window = $window;
			this.dialogService = dialogService;

			this.allowCompressAt = ScreenSize.LARGE;

			this.id = panelId;
			this.alwaysAnimateOpen = alwaysAnimateOpen;
			this.size = size;

			if (this.getPanel().length < 1) {
				throw new Error("Panel with id(" + this.id + ") is missing.");
			}

			//TODO: This doesn't work
			console.log(size);
			switch (size) {
				case PanelSize.COMPRESS:
					this.getPanel().addClass('compress');
					break;
				case PanelSize.EXPAND:
					this.getPanel().addClass('expand');
					break;
			}

			this.initFoundation();
		}

		public open(): void
		{
			var that = this;
			switch (this.size) {
				case PanelSize.EXPAND:
					this.$timeout(function () {
						that.api.publish(that.id, 'open-expanded');
					}, this.delay);
					break;
				case PanelSize.COMPRESS:
					this.$timeout(function () {
						that.api.publish(that.id, 'open');
					}, this.delay);
					break;
			}
		}

		public close(type: string = ''): void
		{
			if (type !== '') {
				this.api.publish(this.id, 'close-' + type);
			} else {
				this.api.publish(this.id, 'close');
			}
		}

		public expand(): void
		{
			var that = this;
			switch (this.size) {
				case PanelSize.COMPRESS:
					this.$timeout(function () {
						that.api.publish(that.id, 'expand');
					}, this.delay);
					this.getPanel().addClass('expand');
					this.getPanel().removeClass('compress');
					this.size = PanelSize.EXPAND;
					break;

				case PanelSize.EXPAND:
					this.$timeout(function () {
						that.api.publish(that.id, 'compress');
					}, this.delay);
					this.getPanel().addClass('compress');
					this.getPanel().removeClass('expand');
					this.size = PanelSize.COMPRESS;
					break;
			}
		}

		public getPanelSize(): PanelSize
		{
			return this.size;
		}

		public getPanel(): IAugmentedJQuery
		{
			return angular.element(document.querySelector('#' + this.id));
		}

		public confirmClose(): boolean
		{
			if (!this.isOpen) {
				return true;
			}

			return this.dialogService.confirm('flashes.panel.close');
		}

		private initFoundation(): void
		{
			var that = this;
			this.api.unsubscribe(this.id);
			this.api.subscribe(this.id, function (message: string)
			{
				switch (message) {
					case 'close':
						var element: Element = document.getElementById(that.id);
						var panelPosition = that.$window.getComputedStyle(element).getPropertyValue("position");
						if (panelPosition === 'static' || panelPosition === 'relative') {
							break;
						}


					case 'close-confirm':
						if (!that.confirmClose()) {
							return;
						}

					case 'close-done':
						//this.panelState = this.defaultPanelOpenState;
						that.animateOpen(false);
						that.removeGridBlock();
						that.isOpen = false;
						break;

					case 'open':
						that.addGridBlock();
						that.animateOpen(true);
						that.isOpen = true;
						break;

					case 'open-expanded':
						that.animateOpen(true);
						that.isOpen = true;
						break;

					case 'expand':
						that.animateExpand(true);
						that.removeGridBlock();
						break;

					case 'compress':
						that.animateExpand(false);
						that.addGridBlock();
						break;

				}
			});
		}

		private animateOpen(active: boolean): void
		{
			if (active && !this.alwaysAnimateOpen && this.isOpen) {
				return;
			}
			this.api.animate(this.getPanel(), active, 'side-panel-in', 'side-panel-out');
		}

		private animateExpand(active: boolean): void
		{
			if (active) {
				this.api.animate(this.getPanel(), true, 'side-panel-expand', '');
			} else {
				this.api.animate(this.getPanel(), true, 'side-panel-compress', '');
			}
		}

		private removeGridBlock(): void
		{
			if (this.allowCompressAt === ScreenSize.NONE) {
				return;
			}

			this.getPanel().removeClass('large-grid-block');
		}

		private addGridBlock(): void
		{
			this.getPanel().addClass('large-grid-block');
		}
	}
}
