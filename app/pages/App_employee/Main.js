var pageAppEmployee = {};
pageAppEmployee.storeobj = Ext.create('App.store.App_employee');
pageAppEmployee.getStore = function(params, start, limit){
	pageAppEmployee.storeobj.removeAll();
    pageAppEmployee.storeobj.load({
        params : {
            params      : ' app_employee.active_flag = 1 '+params,
            start       : start,
            limit       : limit,
        }
    });
}

pageAppEmployee.paramsCriteria  = '';
pageAppEmployee.grid 			= null;
pageAppEmployee.getStore(pageAppEmployee.paramsCriteria, 0, 25);
Ext.define('App.pages.App_employee.Main', {
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
						Ext.create('App.pages.App_employee.form', {
							fbar    : [
								{
									xtype   : 'button',
									text    : 'Save',
									handler : function(btn){
										var win = btn.up('window'), form = win.down('form');

										Ext.Ajax.request({
											method: 'post',
											url: url+"app/C_App_employee/save",
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
												pageAppEmployee.getStore(null, 0, 25);
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
						pageAppEmployee.getStore(pageAppEmployee.paramsCriteria, 0, 25);
					}
				},
				{
					text		: 'Search',
					iconCls		: 'fa fa-search fa-lg',
					iconAlign	: 'top',
					handler 	: function(a) {
						Ext.create('App.pages.App_employee.Search',{
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
		                                pageAppEmployee.getStore(params, 0, 25);
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
						var selected        = pageAppEmployee.grid.getView().getSelectionModel().getSelection();
						Ext.each(selected, function (item) {
							tmp_id.push(item.data.role_id);
						});
		                Ext.MessageBox.confirm('Delete', 'Apa anda yakin untuk menghapus ?', function(btn){
		                    if(btn === 'yes'){
		                        Ext.Ajax.request({
		                            method      : 'post',
		                            url         : url+"app/C_App_employee/delete",
		                            waitTitle   : 'Connecting',
		                            waitMsg     : 'Sending data...',
		                            params      : {
		                                id      : JSON.stringify(tmp_id),
		                            },
		                            // scope:this,
		                            success: function(res){
		                                pageAppEmployee.getStore(null, 0, 25);
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
		pageAppEmployee.grid = Ext.create('Ext.grid.Panel', {
			store: pageAppEmployee.storeobj,
			selModel: Ext.create('Ext.selection.CheckboxModel'),
			columns: [
				{ header: 'Name',  dataIndex: 'first_name', flex : 1,  editor : 'textfield'},
                {
                    header: 'Gender',
                    dataIndex: 'gender',
                    flex : 1,
                    renderer    : function(a){
                        if (a == 0) {
                            return "Perempuan";
                        }else{
                            return "Laki - laki";
                        }
                    }
                },
				{ header: 'Birth date',  dataIndex: 'birth_date', flex : 1,  editor : 'textfield'},
				{ header: 'Job',  dataIndex: 'job_name', flex : 1,  editor : 'textfield'},
				{ header: 'Address',  dataIndex: 'address', flex : 1,  editor : 'textfield'},
                {
                    header: 'Activate',
                    dataIndex: 'active_flag',
                    flex : 1,
                    renderer    : function(a){
                        if (a == 0) {
                            return "<i class='fa fa-minus'></i>";
                        }else{
                            return "<i class='fa fa-check'></i>";
                        }
                    }
                },
			],
			anchor  : '100% 100%',
			width   : '100%',
			height  : '100%',
			dockedItems: [{
				xtype: 'pagingtoolbar',
				store: pageAppEmployee.storeobj,
				pageSize: 10,
				dock: 'bottom',
				displayInfo: true
			}],
            viewConfig: {
                listeners: {
                    itemdblclick: function(dataview, index, item, e) {
                        Ext.create('App.pages.App_employee.form', {
                            fbar    : [
                                {
                                    xtype   : 'button',
                                    text    : 'Update',
                                    handler : function(btn){
                                        var win = btn.up('window'), form = win.down('form');
                                        Ext.Ajax.request({
                                            method: 'post',
                                            url: url+"app/C_App_employee/update",
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
                                                pageAppEmployee.getStore(null, 0, 25);
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
                                    console.log(thisForm.items);
                                    thisForm.items.items[0].setValue(index.data.id_number);
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
		// pageAppEmployee.getStore(pageAppEmployee.paramsCriteria, 0, 25);
		// Ext.getCmp('main.tabC_App_employee').setLoading(false);
		this.callParent();
	},
	listeners: {
		show : function(thisHeader){
			pageAppEmployee.getStore(pageAppEmployee.paramsCriteria, 0, 25);
		},
	},
});