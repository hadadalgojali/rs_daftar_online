Ext.define('App.pages.Rs_jadwal_poli.Main', function(){
	var Variable = {};
	Variable.storeobj = Ext.create('App.store.Rs_jadwal_poli');
	Variable.getStore = function(params, start, limit){
		Variable.storeobj.removeAll();
	    Variable.storeobj.load({
	        params : {
	            params      : params,
	            start       : start,
	            limit       : limit,
	        },
	    });
	}
	Variable.grid  = null;
	Variable.paramsCriteria  = '';
	Variable.pagging = {};
	Variable.pagging.currentPage = 1;
	Variable.pagging.limit 			 = 25;
	Variable.pagging.totalPage   = 25;
	return {
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
							Ext.create('App.pages.Rs_unit.Form', {
								fbar    : [
									{
										xtype   : 'button',
										text    : 'Save',
										handler : function(btn){
											var win = btn.up('window'), form = win.down('form');
											var tmp_gender = 0;
											/*
												win.items.items[0] == unit_id
												win.items.items[1] == unit_type
												win.items.items[2] == unit_code
												win.items.items[3] == unit_name
												win.items.items[4] == kd_unit_bpjs
												win.items.items[5] == active_flag
											*/
											Ext.Ajax.request({
												method: 'post',
												url: url+"app/C_rs_unit/save",
												waitTitle: 'Connecting',
												waitMsg: 'Sending data...',
												params: {
													id 					: win.items.items[0].value,
													unit_type 	: win.items.items[1].value,
													unit_code		: win.items.items[2].value,
													unit_name 	: win.items.items[3].value,
													kd_unit_bpjs: win.items.items[4].value,
													active 			: win.items.items[5].value,
												},
												success: function(res){
													var cst = JSON.parse(res.responseText);
													Ext.Msg.alert("Create", ""+cst.message+"");
													Variable.getStore(Variable.paramsCriteria, 0, 25);
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
							Variable.getStore(Variable.paramsCriteria, 0, 25);
						}
					},
					{
						text		: 'Search',
						iconCls		: 'fa fa-search fa-lg',
						iconAlign	: 'top',
						disabled 	: true,
						handler 	: function(a) {
							Ext.create('App.pages.Rs_unit.Search',{
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
														Variable.paramsCriteria += " AND (lower(role_code) like lower('%"+win.items.items[0].lastValue+"%') OR lower(role_code) like lower('%"+win.items.items[0].lastValue+"%'))";
													}
												}
												if (win.items.items[1].lastValue != undefined) {
													if (win.items.items[1].lastValue != "") {
														// if (params != "") {
															// 	params += " AND ";
															// }
															Variable.paramsCriteria += " AND (lower(role_name) like lower('%"+win.items.items[1].lastValue+"%') OR lower(role_name) like lower('%"+win.items.items[1].lastValue+"%'))";
														}
													}
													Variable.getStore(params, 0, 25);
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
									var selected        = Variable.grid.getView().getSelectionModel().getSelection();
									Ext.each(selected, function (item) {
										tmp_id.push(item.data.unit_id);
									});
									Ext.MessageBox.confirm('Delete', 'Apa anda yakin untuk menghapus ?', function(btn){
										if(btn === 'yes'){
											Ext.Ajax.request({
												method      : 'post',
												url         : url+"app/C_rs_unit/delete",
												waitTitle   : 'Connecting',
												waitMsg     : 'Sending data...',
												params      : {
													id      : JSON.stringify(tmp_id),
												},
												// scope:this,
												success: function(res){
													if (res.status == 200) {
														var obj = JSON.parse(res.responseText);
														if (obj.status == 200) {
															Variable.getStore(Variable.paramsCriteria, 0, 25);
														}
													}
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
					Variable.grid = Ext.create('Ext.grid.Panel', {
						store: Variable.storeobj,
						selModel: Ext.create('Ext.selection.CheckboxModel'),
						columns: [
							{ header: 'Unit Type',  dataIndex: 'unit_type', width : 120,  editor : 'textfield'},
							{ header: 'Unit Code',  dataIndex: 'unit_code', width : 120,  editor : 'textfield'},
							{ header: 'Unit name',  dataIndex: 'unit_name', flex : 1,  editor : 'textfield'},
							{ header: 'Kode BPJS',  dataIndex: 'kd_unit_bpjs', flex : 1,  editor : 'textfield'},
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
			                },
						],
						anchor  : '100% 100%',
						width   : '100%',
						height  : '100%',
						dockedItems: [{
							xtype: 'pagingtoolbar',
							store: Variable.storeobj,
							dock: 'bottom',
							displayInfo: true,
						}],
						viewConfig: {
							listeners: {
								itemdblclick: function(dataview, index, item, e) {
									Ext.create('App.pages.Rs_unit.Form', {
										fbar    : [
											{
												xtype   : 'button',
												text    : 'Update',
												handler : function(btn){
													var win = btn.up('window'), form = win.down('form');
													Ext.Ajax.request({
														method: 'post',
														url: url+"app/C_rs_unit/update",
														waitTitle: 'Connecting',
														waitMsg: 'Sending data...',
														params: {
															id 					: win.items.items[0].value,
															unit_type 	: win.items.items[1].value,
															unit_code		: win.items.items[2].value,
															unit_name 	: win.items.items[3].value,
															kd_unit_bpjs: win.items.items[4].value,
															active 			: win.items.items[5].value,
														},
														success: function(res){
															var cst = JSON.parse(res.responseText);
															Ext.Msg.alert("Update", ""+cst.message+"");
															Variable.getStore(Variable.paramsCriteria, 0, 25);
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
												console.log(thisForm);
												thisForm.items.items[0].setValue(index.data.unit_id);
												thisForm.items.items[1].setValue(index.data.unit_type);
												thisForm.items.items[2].setValue(index.data.unit_code);
												thisForm.items.items[3].setValue(index.data.unit_name);
												thisForm.items.items[4].setValue(index.data.kd_unit_bpjs);
												if (index.data.active_flag == 1) {
													thisForm.items.items[5].setValue(true);
												}
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
					Variable.getStore(Variable.paramsCriteria, 0, 25);
				},
	}
});
