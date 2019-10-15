var pageAppRole = {};
pageAppRole.storeobj = Ext.create('App.store.App_role');
pageAppRole.getStore = function(params, start, limit){
	pageAppRole.storeobj.removeAll();
    pageAppRole.storeobj.load({
        params : {
            params      : ' active_flag = 1 '+params,
            start       : start,
            limit       : limit,
        }
    });
}

pageAppRole.paramsCriteria  = '';
pageAppRole.grid 			= null;
pageAppRole.getStore(pageAppRole.paramsCriteria, 0, 25);
Ext.define('App.pages.App_role.Main', {
	extend : 'App.cmp.Panel',
	layout :'fit',
	tbar 		: [
		{
			xtype		: 'buttongroup',
			// columns		: 3,
			title		: 'Menu',
			bodyStyle	: 'margin:0px;margin-right:10px;padding:0px;',
			style		: 'margin:0px;margin-right:10px;padding:0px;',
			items: [
				{
					text		: 'Tambah',
					iconCls		: 'fa fa-plus fa-lg',
					iconAlign	: 'top',
					handler 	: function(a) {
						Ext.create('App.pages.App_role.form', {
							fbar    : [
								{
									xtype   : 'button',
									text    : 'Save',
									handler : function(btn){
										var win = btn.up('window'), form = win.down('form');

										Ext.Ajax.request({
											method: 'post',
											url: url+"app/C_app_role/save",
											waitTitle: 'Connecting',
											waitMsg: 'Sending data...',
											params: {
												'id'        	: win.items.items[0].lastValue,
												'role_code' 	: win.items.items[1].lastValue,
												'role_name' 	: win.items.items[2].lastValue,
												'description'   : win.items.items[3].lastValue,
											},
											success: function(res){
												var cst = JSON.parse(res.responseText);
												Ext.Msg.alert("Create", ""+cst.message+"");
												pageAppRole.getStore(null, 0, 25);
											},
											failure: function(){
												console.log('failure');
											}
										});
									}
								},{
									xtype   : 'button',
									text    : 'Close',
									handler : function(btn){
										var win = btn.up('window');
										win.close();
									}
								},
							]
						}).show();
					}
				},
				{
					text		: 'Refresh',
					iconCls		: 'fa fa-refresh fa-lg',
					iconAlign	: 'top',
					handler 	: function(a) {
						pageAppRole.getStore(pageAppRole.paramsCriteria, 0, 25);
					}
				},
				{
					text		: 'Search',
					iconCls		: 'fa fa-search fa-lg',
					iconAlign	: 'top',
					handler 	: function(a) {
						Ext.create('App.pages.App_role.Search',{
							title   : "Search App Role",
							fbar    : [
								{
									xtype   : 'button',
									text    : 'Search',
									handler : function(btn){
										var win    = btn.up('window'), form = win.down('form');
										var params = "";

										if (win.items.items[0].lastValue != undefined) {
											if (win.items.items[0].lastValue != "") {
												// if (params != "") {
												// 	params += " AND ";
												// }
												params += " AND (lower(role_code) like lower('%"+win.items.items[0].lastValue+"%') OR lower(role_code) like lower('%"+win.items.items[0].lastValue+"%'))";
											}
										}
										if (win.items.items[1].lastValue != undefined) {
											if (win.items.items[1].lastValue != "") {
												// if (params != "") {
												// 	params += " AND ";
												// }
												params += " AND (lower(role_name) like lower('%"+win.items.items[1].lastValue+"%') OR lower(role_name) like lower('%"+win.items.items[1].lastValue+"%'))";
		                                    }
										}
		                                pageAppRole.getStore(params, 0, 25);
									}
								},{
									xtype   : 'button',
									text    : 'Close',
									handler : function(btn){
										var win = btn.up('window');
										win.close();
									}
								}
							],
						}).show();
					}
				},
				{
					text		: 'Hapus',
					iconCls		: 'fa fa-minus fa-lg',
					iconAlign	: 'top',
					handler 	: function(a) {
						var tmp_id = [];
						var selected        = pageAppRole.grid.getView().getSelectionModel().getSelection();
						Ext.each(selected, function (item) {
							tmp_id.push(item.data.role_id);
						});
		                Ext.MessageBox.confirm('Delete', 'Apa anda yakin untuk menghapus ?', function(btn){
		                    if(btn === 'yes'){
		                        Ext.Ajax.request({
		                            method      : 'post',
		                            url         : url+"app/C_app_role/delete",
		                            waitTitle   : 'Connecting',
		                            waitMsg     : 'Sending data...',
		                            params      : {
		                                id      : JSON.stringify(tmp_id),
		                            },
		                            // scope:this,
		                            success: function(res){
		                                pageAppRole.getStore(null, 0, 25);
		                            },
		                            failure: function(){
		                                console.log('failure');
		                            }
		                        });
		                    }
		                });
					}
				},
		    ]
		},
		{
			xtype		: 'buttongroup',
			columns		: 2,
			title		: 'Export',
			bodyStyle	: 'margin:0px;padding:0px;',
			style		: 'margin:0px;padding:0px;',
			items: [
				{
					text		: 'Excel',
					iconCls		: 'fa fa-file-excel-o fa-lg',
					iconAlign	: 'top',
					handler 	: function(a) {
					}
				},
				{
					text		: 'PDF',
					iconCls		: 'fa fa-file-pdf-o fa-lg',
					iconAlign	: 'top',
					handler 	: function(a) {
					}
				},
			]
		},
	],
	items : [
		pageAppRole.grid = Ext.create('Ext.grid.Panel', {
			store: pageAppRole.storeobj,
			selModel: Ext.create('Ext.selection.CheckboxModel'),
			columns: [
				{ header: 'Role code',  dataIndex: 'role_code', width : 200,  editor : 'textfield'},
				{ header: 'Role name',  dataIndex: 'role_name', flex : 1,  editor : 'textfield'},
				{ header: 'Description',  dataIndex: 'description', flex : 1,  editor : 'textfield'},
			],
			anchor  : '100% 100%',
			width   : '100%',
			height  : '100%',
			dockedItems: [{
				xtype: 'pagingtoolbar',
				store: pageAppRole.storeobj,
				pageSize: 10,
				dock: 'bottom',
				displayInfo: true
			}],
            viewConfig: {
                listeners: {
                    itemdblclick: function(dataview, index, item, e) {
                        Ext.create('App.pages.App_role.form', {
                            fbar    : [
                                {
                                    xtype   : 'button',
                                    text    : 'Update',
                                    handler : function(btn){
                                        var win = btn.up('window'), form = win.down('form');
                                        Ext.Ajax.request({
                                            method: 'post',
                                            url: url+"app/C_app_role/update",
                                            waitTitle: 'Connecting',
                                            waitMsg: 'Sending data...',
                                            params: {
												'id'        	: win.items.items[0].lastValue,
												'role_code' 	: win.items.items[1].lastValue,
												'role_name' 	: win.items.items[2].lastValue,
												'description'   : win.items.items[3].lastValue,
                                            },
                                            success: function(res){
                                                var cst = JSON.parse(res.responseText);
                                                Ext.Msg.alert("Update", ""+cst.message+"");
                                                pageAppRole.getStore(null, 0, 25);
                                            },
                                            failure: function(){
                                                console.log('failure');
                                            }
                                        });
                                    }
                                },{
                                    xtype   : 'button',
                                    text    : 'Close',
                                    handler : function(btn){
                                        var win = btn.up('window');
                                        win.close();
                                    }
                                },
                            ],
                            listeners: {
                                show: function(thisForm){
                                    // console.log(thisHeader);
                                    thisForm.items.items[0].setValue(index.data.role_id);
                                    thisForm.items.items[1].setValue(index.data.role_code);
                                    thisForm.items.items[2].setValue(index.data.role_name);
                                    thisForm.items.items[3].setValue(index.data.description);
                                },
                            }
                        }).show();
                    }
                }
            },
			renderTo: Ext.getBody()
        }),
	],
	initComponent:function(){
		// pageAppRole.getStore(pageAppRole.paramsCriteria, 0, 25);
		// Ext.getCmp('main.tabC_app_role').setLoading(false);
		this.callParent();
	},
	listeners: {
		show : function(thisHeader){
			pageAppRole.getStore(pageAppRole.paramsCriteria, 0, 25);
		},
	},
});