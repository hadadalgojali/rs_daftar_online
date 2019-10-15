Ext.define('App.system.Main', {
	extend 		: 'Ext.container.Viewport',
	controllers : ['main'],
	layout 		: {
		type 	: 'vbox',
		align 	: 'stretch'
	},
	bodyStyle	: 'margin:0px;padding:0px;',
	style		: 'margin:0px;padding:0px;',
	items		: [
		new Ext.create('App.cmp.Confirm', {
			id : 'main.confirm'
		}),
		new Ext.toolbar.Toolbar({
			id : 'main.toolbar',
			style:'margin-top: -1px;background-color:#157fcc;',
			layout : {
				overflowHandler : 'Menu'
			}
		}), 
		new Ext.tab.Panel({
			id : 'main.body',
			style : {
				'margin-top' : '5px'
			},
			autoDestroy : false,
			flex 		: 1,
			scrollable 	: false,
			autoScroll 	: false,
			layout 		: 'fit',
			items : [
				new Ext.create('App.pages.Home')
			]
		}),
		new Ext.toolbar.Toolbar({
			id : 'main.toolbar.window',
			style:'margin-top: -2px;',
			bodyStyle:'padding-right: -1px;',
			layout : {
				overflowHandler : 'Menu'
			},
			
			items:['->','-',
				new Ext.form.DisplayField({
					width : 80,
					style:'text-align:center;',
					id:'main.time',
					value : '00:00:00'
				})
			]
		})
	],
	addTab : function(r) {
		var $this = this,
			mainTab=null;
		Ext.getCmp('main.body').add({
			title : r.text,
			id : 'main.tab' + r.code,
			code : r.code,
			closable : true,
			closing : false,
			closeAction : 'hide',
			layout : 'fit',
			listeners : {
				beforeclose : {
					fn : function(t) {
						if (t.closing == false) {
							var win = t.query('window'),
								hidden = true;
							for (var i = 0, iLen = win.length; i < iLen; i++)
								if (win[i].hidden == false) {
									hidden = false;
									break;
								}
							if (hidden == true)
								Ext.getCmp('main.confirm').confirm({
									msg : 'Are You Sure Close This Tab?',
									allow : 'main.close.tab',
									onY : function() {
										Ext.getCmp('main.tab'+ t.code).closing = true;
										Ext.getCmp('main.body').remove(t);
										// delete tabVar[t.code];
									}
								});
							else
								new Ext.create('App.cmp.Toast').toast({msg : 'Please Close All Windows.',type : 'information'});
							return false;
						}else
							return true;
					}
				}
			}
		});
		mainTab=Ext.getCmp('main.tab' + r.code);
		Ext.getCmp('main.body').setActiveTab(mainTab);
		mainTab.add(new Ext.create(r.role));
	},
	loadMenu : function(a) {
		var $this = this,
			mainTab=Ext.getCmp('main.tab'+ a.code);
		if (a.win == false)
			if (mainTab == undefined){
				$this.addTab(a);
			}else {
				if (mainTab.closing == false)
					Ext.getCmp('main.body').setActiveTab(mainTab);
				else{
					Ext.getCmp('main.body').add(mainTab);
					mainTab.closing = false;
					Ext.getCmp('main.body').setActiveTab(mainTab);
					Ext.getCmp('main.tab' + a.code).unmask();
				}
			}
		else{
			var win=Ext.getCmp(a.code.toLowerCase());
			if(win == undefined){
				win=new Ext.create(a.role);
				Ext.getCmp('main.toolbar.window').insert(0,new Ext.Button({
					text:a.text,
					iconCls:'i-window',
					maxWidth: 120,
					id:'main.toolbar.window.'+a.code.toLowerCase(),
					handler:function(){
						win.show();
					}
				}));
			}
			win.show();
		}
	},

	SettingMenu : function(_menu) {
		var $this = this,
			menu = [],
			iVar=null;
		console.log(_menu);
		for (var i = 0,iLen=_menu.length; i <iLen ; i++) {
			iVar=_menu[i];
			if(iVar.handler != undefined) {
				iVar.handler = function(){
					$this.loadMenu(this);
				}
				menu.push(iVar);
			}else{
				if (iVar.menu != undefined) {
					menu.push($this.SettingMenu(iVar.menu));
					console.log(iVar.menu);
				}
			}
		}
		return menu;
	},
	initComponent : function() {
		var $this = this,
			toolbar=Ext.getCmp('main.toolbar');

		toolbar.add(new Ext.form.DisplayField({
			id 		: 'main.toolbar.title',
			value 	: '<b>NCI MEDISMART</b>',
			style 	: 'margin-top:5px;'
		}),'-');

		$this.SettingMenu(session.menu);

		for (var i = 0,iLen=session.menu.length; i <iLen ; i++){
			toolbar.add(session.menu[i]);
		}

		toolbar.add(
			'->',
			{
				text : '<b>' + session.user.first_name + '</b>',
				iconCls : 'fa fa-user',
				menu : {
					xType : 'menu',
					plain : true,
					items : [
				        {
							text : 'Profile',
							iconCls : 'fa fa-user',
							handler:function(){
								Ext.getCmp('main.body').setActiveTab(Ext.getCmp('main.tab.home'));
								Ext.getCmp('home.btnProfile').btnEl.dom.click();
							}
						}, '-', {
							text : 'Logout',
							iconCls : 'fa fa-power-off',
							handler : function() {
								Ext.getCmp('main.confirm').confirm({
									msg : 'Are you sure logout ?',
									onY : function() {
										Ext.getBody().mask('Logout');
										Ext.Ajax.request({
											url 	: url + 'Auth/destroy_session',
											method 	: 'GET',
											success : function(response) {
												Ext.getBody().unmask();
												if (response.status == 200) {
													location.reload();
												}
											},
											failure : function(jqXHR, exception) {
												Ext.getBody().unmask();
												ajaxError(jqXHR, exception);
											}
										});
									}
								});
							}
						}
					]
				}
			}
		);

		this.callParent(arguments);
		startTime();
		function startTime() {
		    var today = new Date();
		    var h = today.getHours();
		    var m = today.getMinutes();
		    var s = today.getSeconds();
		    m = checkTime(m);
		    s = checkTime(s);
		    Ext.getCmp('main.time').setValue(h + ":" + m + ":" + s);
		    var t = setTimeout(startTime, 500);
		}
		function checkTime(i) {
		    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
		    return i;
		}
	}
});