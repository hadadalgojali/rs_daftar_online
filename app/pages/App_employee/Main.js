var pageAppEmployee = {};
pageAppEmployee.storeobj = Ext.create('App.store.App_employee');
pageAppEmployee.getStore = function(params, start, limit){
	pageAppEmployee.storeobj.removeAll();
    pageAppEmployee.storeobj.load({
        params : {
            params      : params,
            start       : start,
            limit       : limit,
        }
    });
}

pageAppEmployee.paramsCriteria  = '';
pageAppEmployee.grid 			= null;
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
										var tmp_gender = 0;
										if (win.items.items[0].items.items[0].items.items[4].items.items[0].value === true) {
											tmp_gender = 1;
										}
										Ext.Ajax.request({
											method: 'post',
											url: url+"app/C_app_employee/save",
											waitTitle: 'Connecting',
											waitMsg: 'Sending data...',
											params: {
												'id_number'  	: win.items.items[0].items.items[0].items.items[1].value,
												'first_name' 	: win.items.items[0].items.items[0].items.items[2].value,
												'last_name' 	: win.items.items[0].items.items[0].items.items[3].value,
												'gender' 		: tmp_gender,
												'religion' 		: win.items.items[0].items.items[0].items.items[5].value,
												'birth_place' 	: win.items.items[0].items.items[0].items.items[6].value,
												'birth_date' 	: win.items.items[0].items.items[0].items.items[7].value,
												'address' 		: win.items.items[0].items.items[0].items.items[8].value,

												'email' 		: win.items.items[0].items.items[1].items.items[0].value,
												'phone_1' 		: win.items.items[0].items.items[1].items.items[1].value,
												'phone_2' 		: win.items.items[0].items.items[1].items.items[2].value,
												'fax' 			: win.items.items[0].items.items[1].items.items[3].value,

												'job_id' 		: win.dockedItems.items[1].items.items[0].items.items[0].value,
												'active' 		: win.dockedItems.items[1].items.items[0].items.items[1].value,
												'tenant_id' : win.dockedItems.items[1].items.items[0].items.items[2].value,

											},
											success: function(res){
												var cst = JSON.parse(res.responseText);
												Ext.Msg.alert("Create", ""+cst.message+"");
												pageAppEmployee.getStore(pageAppEmployee.paramsCriteria, 0, 25);
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
					disabled 	: true,
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
												pageAppEmployee.paramsCriteria += " AND (lower(role_code) like lower('%"+win.items.items[0].lastValue+"%') OR lower(role_code) like lower('%"+win.items.items[0].lastValue+"%'))";
											}
										}
										if (win.items.items[1].lastValue != undefined) {
											if (win.items.items[1].lastValue != "") {
												// if (params != "") {
												// 	params += " AND ";
												// }
												pageAppEmployee.paramsCriteria += " AND (lower(role_name) like lower('%"+win.items.items[1].lastValue+"%') OR lower(role_name) like lower('%"+win.items.items[1].lastValue+"%'))";
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
							tmp_id.push(item.data.employee_id);
						});
		                Ext.MessageBox.confirm('Delete', 'Apa anda yakin untuk menghapus ?', function(btn){
		                    if(btn === 'yes'){
		                        Ext.Ajax.request({
		                            method      : 'post',
		                            url         : url+"app/C_app_employee/delete",
		                            waitTitle   : 'Connecting',
		                            waitMsg     : 'Sending data...',
		                            params      : {
		                                id      : JSON.stringify(tmp_id),
		                            },
		                            // scope:this,
		                            success: function(res){
		                                pageAppEmployee.getStore(pageAppEmployee.paramsCriteria, 0, 25);
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
                        if (a == 0 || a == 'f' || a == 'false') {
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
                            return "<i class='fa fa-close'></i>";
                        }else{
                            return "<i class='fa fa-check'></i>";
                        }
                    }
                },{
					xtype   : 'actioncolumn',
					text    : 'Account',
					width   : 200,
					items   : [
						{
							tooltip 	: 'Operate User Account',
							icon 		: './assets/image/icons/icons8-writer-male-24.png',
							handler 	: function( view, rowIndex, colIndex , item, e, record, row ) {
								Ext.create('App.pages.App_user.Form', {
									fbar    : [
										{
											xtype   : 'button',
											text    : 'Save',
											handler : function(btn){
												var win = btn.up('window');
												// form.items[0] => username
												// form.items[1] => checkbox using password or not
												// form.items[2] => password
												// form.items[3] => retype password
												// form.items[4] => Combo role
												// form.items[5] => Combo tenant
												// form.items[6] => Checkbox Active
												var form = win.items.items[0].items;
												if (form.items[2].getValue() !== form.items[3].getValue()) {
													Ext.Msg.alert("Peringatan", " Password not same ");
												}else{

																							Ext.Ajax.request({
																									method: 'post',
																									url: url+"app/C_app_employee/user_generate",
																									waitTitle: 'Connecting',
																									waitMsg: 'Sending data...',
																									params: {
																										employee_id 		: record.data.employee_id,
																										username 				: form.items[0].getValue(),
																										change_password : form.items[1].getValue(),
																										password 				: form.items[2].getValue(),
																										role 						: form.items[4].getValue(),
																										tenant_id 			: form.items[5].getValue(),
																										active					: form.items[6].getValue(),
																									},
																									success: function(res){
																											var cst = JSON.parse(res.responseText);
																											Ext.Msg.alert("Update", ""+cst.message+"");
																											pageAppEmployee.getStore(pageAppEmployee.paramsCriteria, 0, 25);
																									},
																									failure: function(){
																											console.log('failure');
																									}
																							});
												}
												console.log(form.items[0].getValue());
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
									listeners: {
										show: function(thisForm){
											// thisForm.items.items[0].items.items[0].items.items[5].setValue(record.data.religion);
											thisForm.items.items[0].items.items[0].setValue(record.data.user_code);
											thisForm.items.items[0].items.items[4].setValue(record.data.role_id);
											thisForm.items.items[0].items.items[5].setValue(record.data.tenant_id);
											thisForm.items.items[0].items.items[6].setValue(record.data.active_flag_user);
											console.log(thisForm.items.items[0].items);
										}
									}
								}).show();
							}
						},{
							tooltip 	: 'View detail Employee',
							icon 		: './assets/image/icons/icons8-profiles-24.png',
							style 		: 'margin-left:5px;',
							handler 	: function( view, rowIndex, colIndex , item, e, record, row ) {
								Ext.create('App.pages.App_employee.form', {
									fbar    : [
										{
											xtype   : 'button',
											text    : 'Close',
											handler : function(btn){
												var win = btn.up('window');
												win.close();
											}
										}
									],
									listeners: {
										show: function(thisForm){
											thisForm.items.items[0].items.items[0].items.items[0].setReadOnly(true);
											thisForm.items.items[0].items.items[0].items.items[1].setReadOnly(true);
											thisForm.items.items[0].items.items[0].items.items[2].setReadOnly(true);
											thisForm.items.items[0].items.items[0].items.items[3].setReadOnly(true);
											thisForm.items.items[0].items.items[0].items.items[5].setReadOnly(true);
											thisForm.items.items[0].items.items[0].items.items[6].setReadOnly(true);
											thisForm.items.items[0].items.items[0].items.items[7].setReadOnly(true);
											thisForm.items.items[0].items.items[0].items.items[8].setReadOnly(true);
											thisForm.items.items[0].items.items[1].items.items[0].setReadOnly(true);
											thisForm.items.items[0].items.items[1].items.items[1].setReadOnly(true);
											thisForm.items.items[0].items.items[1].items.items[2].setReadOnly(true);
											thisForm.items.items[0].items.items[1].items.items[3].setReadOnly(true);
											thisForm.items.items[0].items.items[0].items.items[4].setReadOnly(true);
											thisForm.dockedItems.items[1].items.items[0].items.items[0].setReadOnly(true);
											thisForm.dockedItems.items[1].items.items[0].items.items[1].setReadOnly(true);
											thisForm.dockedItems.items[1].items.items[0].items.items[2].setReadOnly(true);

											thisForm.items.items[0].items.items[0].items.items[0].setValue(record.data.employee_id);
											thisForm.items.items[0].items.items[0].items.items[1].setValue(record.data.id_number);
											thisForm.items.items[0].items.items[0].items.items[2].setValue(record.data.first_name);
											thisForm.items.items[0].items.items[0].items.items[3].setValue(record.data.last_name);
											if (record.data.gender == 'true' ) {
												thisForm.items.items[0].items.items[0].items.items[4].items.items[0].setValue(true);
											}else{
												thisForm.items.items[0].items.items[0].items.items[4].items.items[1].setValue(true);
											}
											thisForm.items.items[0].items.items[0].items.items[5].setValue(record.data.religion);
											thisForm.items.items[0].items.items[0].items.items[6].setValue(record.data.birth_place);
											thisForm.items.items[0].items.items[0].items.items[7].setValue(record.data.birth_date);
											thisForm.items.items[0].items.items[0].items.items[8].setValue(record.data.address);
											thisForm.items.items[0].items.items[1].items.items[0].setValue(record.data.email_address);
											thisForm.items.items[0].items.items[1].items.items[1].setValue(record.data.phone_number1);
											thisForm.items.items[0].items.items[1].items.items[2].setValue(record.data.phone_number2);
											thisForm.items.items[0].items.items[1].items.items[3].setValue(record.data.fax_number1);

											thisForm.dockedItems.items[1].items.items[0].items.items[0].setValue(record.data.job_id);
											thisForm.dockedItems.items[1].items.items[0].items.items[2].setValue(record.data.tenant_id);
											if (record.data.active_flag == 1) {
												thisForm.dockedItems.items[1].items.items[0].items.items[1].setValue(true);
											}
										}
									}
								}).show();
							}
						},
					]
				}
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
										var tmp_gender = 0;
										if (win.items.items[0].items.items[0].items.items[4].items.items[0].value === true) {
											tmp_gender = 1;
										}
                                        Ext.Ajax.request({
                                            method: 'post',
                                            url: url+"app/C_app_employee/update",
                                            waitTitle: 'Connecting',
                                            waitMsg: 'Sending data...',
                                            params: {
																							'employee_id'  	: win.items.items[0].items.items[0].items.items[0].value,
																							'id_number'  	: win.items.items[0].items.items[0].items.items[1].value,
																							'first_name' 	: win.items.items[0].items.items[0].items.items[2].value,
																							'last_name' 	: win.items.items[0].items.items[0].items.items[3].value,
																							'gender' 		: tmp_gender,
																							'religion' 		: win.items.items[0].items.items[0].items.items[5].value,
																							'birth_place' 	: win.items.items[0].items.items[0].items.items[6].value,
																							'birth_date' 	: win.items.items[0].items.items[0].items.items[7].value,
																							'address' 		: win.items.items[0].items.items[0].items.items[8].value,

																							'email' 		: win.items.items[0].items.items[1].items.items[0].value,
																							'phone_1' 		: win.items.items[0].items.items[1].items.items[1].value,
																							'phone_2' 		: win.items.items[0].items.items[1].items.items[2].value,
																							'fax' 			: win.items.items[0].items.items[1].items.items[3].value,

																							'job_id' 		: win.dockedItems.items[1].items.items[0].items.items[0].value,
																							'active' 		: win.dockedItems.items[1].items.items[0].items.items[1].value,
																							'tenant_id'	: win.dockedItems.items[1].items.items[0].items.items[2].value,
                                            },
                                            success: function(res){
                                                var cst = JSON.parse(res.responseText);
                                                Ext.Msg.alert("Update", ""+cst.message+"");
                                                pageAppEmployee.getStore(pageAppEmployee.paramsCriteria, 0, 25);
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
                                    thisForm.items.items[0].items.items[0].items.items[0].setValue(index.data.employee_id);
                                    thisForm.items.items[0].items.items[0].items.items[1].setValue(index.data.id_number);
                                    thisForm.items.items[0].items.items[0].items.items[2].setValue(index.data.first_name);
                                    thisForm.items.items[0].items.items[0].items.items[3].setValue(index.data.last_name);
                                    if (index.data.gender == 'true' || index.data.gender == 't' ) {
                                    	thisForm.items.items[0].items.items[0].items.items[4].items.items[0].setValue(true);
                                    }else{
                                    	thisForm.items.items[0].items.items[0].items.items[4].items.items[1].setValue(true);
                                    }
                                    thisForm.items.items[0].items.items[0].items.items[5].setValue(index.data.religion);
                                    thisForm.items.items[0].items.items[0].items.items[6].setValue(index.data.birth_place);
                                    thisForm.items.items[0].items.items[0].items.items[7].setValue(index.data.birth_date);
                                    thisForm.items.items[0].items.items[0].items.items[8].setValue(index.data.address);
                                    thisForm.items.items[0].items.items[1].items.items[0].setValue(index.data.email_address);
                                    thisForm.items.items[0].items.items[1].items.items[1].setValue(index.data.phone_number1);
                                    thisForm.items.items[0].items.items[1].items.items[2].setValue(index.data.phone_number2);
                                    thisForm.items.items[0].items.items[1].items.items[3].setValue(index.data.fax_number1);

                                    thisForm.dockedItems.items[1].items.items[0].items.items[0].setValue(index.data.job_id);
                                    if (index.data.active_flag == 1) {
                                    	thisForm.dockedItems.items[1].items.items[0].items.items[1].setValue(true);
                                    }
																		thisForm.dockedItems.items[1].items.items[0].items.items[2].setValue(index.data.tenant_id);
                                },
                            }
                        }).show();
                    }
                }
            },
			// renderTo: Ext.getBody()
        }),
	],
	initComponent:function(){
		this.callParent();
		pageAppEmployee.getStore(pageAppEmployee.paramsCriteria, 0, 25);
	},
});
