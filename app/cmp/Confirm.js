Ext.define('App.cmp.Confirm', {
	extend : 'Ext.window.Window',
	msg : '',
	title : 'Confirmation',
	constrain : true,
	bodyStyle : 'background:transparent;',
	q : {
		type : 'confirm'
	},
	modal : true,
	als : '',
	closeAction : 'hide',
	resizable : false,
	autoWidth : true,
	border : false,
	minWidth 	: 300,
	allow : [],
	confirm : function(dat) {
		var item=this.items.items[1],
			datAllow=this.allow[dat.allow];
		item.setValue(false);
		item.hide();
		this.als = '';
		if (dat.msg != undefined)
			this.items.items[0].items.items[1].setValue(dat.msg);
		if (dat.onY != undefined)
			this.onY = dat.onY;
		if (dat.onN != undefined)
			this.onN = dat.onN;
		if (dat.allow != undefined) {
			if (datAllow == undefined)
				datAllow = false;
			if (datAllow == false) {
				this.als = dat.allow;
				item.show();
				this.show();
			}else
				if(this.onY != undefined){
					this.close();
					this.onY();
				}
		}else
			this.show();
	},
	listeners : {
		show : function(a) {
			a.center();
			a.qYesButton.focus();
		}
	},
	initComponent : function() {
		var $this = this;
		$this.items = [
			Ext.create('App.cmp.Panel', {
				bodyStyle : 'background:transparent;',
				layout : {
					type : 'hbox',
					align : 'stretch',
					width 	: '100%',
				},
				minWidth 	: 300,
				items : [
					new Ext.Img({
						// iconCls 	: 'fa fa-info-circle',
						width 		: 0,
						height 		: 0
					}), {
						xtype : 'displayfield',
						style : 'padding:10px;',
						value : $this.msg
					}
				]
			}), new Ext.form.field.Checkbox({
				style : 'margin-left: 10px;',
				boxLabel : 'Do not ask again.'
			})
		];
		$this.fbar = [
			$this.qYesButton= new Ext.Button({
				text : 'Yes',
				iconCls : 'fa fa-check fa-lg',
				handler : function() {
					$this.close();
					if ($this.als != '' && $this.items.items[1].getValue() == true) 
						$this.allow[$this.als] = true;
					if ($this.onY != undefined)
						$this.onY();
				}
			}),new Ext.Button({
				text : 'No',
				iconCls : 'fa fa-close fa-lg',
				handler : function() {
					$this.close();
					if ($this.onN != undefined)
						$this.onN();
				}
			})
		];
		$this.callParent(arguments);
	}
});