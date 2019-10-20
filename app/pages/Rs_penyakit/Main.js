Ext.define('App.pages.Rs_penyakit.Main', function(){
	var Variable = {};
	Variable.storeobj = Ext.create('App.store.Rs_penyakit');
	Variable.getStore = function(params, start, limit){
		Variable.storeobj.removeAll();
	    Variable.storeobj.load({
	        params : {
	            params      : params,
	            start       : start,
	            limit       : limit,
	        },
					callback : function(){
						console.log(Variable.storeobj);
						// Variable.grid.totalCount = gridStore.count(); //update the totalCount property of Store
						// pagingToolbar.onLoad();
					}
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
							Ext.create('App.pages.Rs_penyakit.Form', {
								fbar    : [
									{
										xtype   : 'button',
										text    : 'Save',
										handler : function(btn){
											var win = btn.up('window'), form = win.down('form');
											var tmp_gender = 0;
											/*
												win.items.items[0] == kd_penyakit
												win.items.items[1] == parent
												win.items.items[2] == penyakit
												win.items.items[3] == description
												win.items.items[4] == note
												win.items.items[5] == includes
												win.items.items[6] == exclude
												win.items.items[7] == status
												win.items.items[8] == non_rujukan_flag
											*/
											Ext.Ajax.request({
												method: 'post',
												url: url+"app/C_rs_penyakit/save",
												waitTitle: 'Connecting',
												waitMsg: 'Sending data...',
												params: {
													kd_penyakit 			: win.items.items[0].value,
													parent 						: win.items.items[1].value,
													penyakit					: win.items.items[2].value,
													description 			: win.items.items[3].value,
													note 							: win.items.items[4].value,
													includes 					: win.items.items[5].value,
													exclude 					: win.items.items[6].value,
													status						: win.items.items[7].value,
													non_rujukan_flag	: win.items.items[8].value,
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
							Ext.create('App.pages.Rs_penyakit.Search',{
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
										tmp_id.push(item.data.kd_penyakit);
									});
									Ext.MessageBox.confirm('Delete', 'Apa anda yakin untuk menghapus ?', function(btn){
										if(btn === 'yes'){
											Ext.Ajax.request({
												method      : 'post',
												url         : url+"app/C_rs_penyakit/delete",
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
							/*

					      'kd_penyakit',
					      'parent',
					      'penyakit',
					      'includes',
					      'exclude',
					      'note',
					      'status',
					      'description',
					      'non_rujukan_flag',
							*/
							{ header: 'Kd Penyakit',  dataIndex: 'kd_penyakit', width : 100,  editor : 'textfield'},
							{ header: 'Penyakit',  dataIndex: 'penyakit',  flex : 1,  editor : 'textfield'},
							{ header: 'Deskripsi',  dataIndex: 'description', flex : 1,   editor : 'textfield'},
							{ header: 'Note',  dataIndex: 'note', flex : 1,  editor : 'textfield'},
							{ header: 'Includes',  dataIndex: 'includes', width : 120,  editor : 'textfield'},
							{ header: 'Exclude',  dataIndex: 'exclude', width : 120,  editor : 'textfield'},
			                {
			                    header: 'Status',
			                    dataIndex: 'status',
			                    width : 72,
			                    renderer    : function(a){
			                        if (a == 0) {
			                            return "<i class='fa fa-close'></i>";
			                        }else{
			                            return "<i class='fa fa-check'></i>";
			                        }
			                    }
			                },
			                {
			                    header: 'Non Rujuk',
			                    dataIndex: 'non_rujukan_flag',
			                    width : 72,
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
									Ext.create('App.pages.Rs_penyakit.Form', {
										fbar    : [
											{
												xtype   : 'button',
												text    : 'Update',
												handler : function(btn){
													var win = btn.up('window'), form = win.down('form');
													Ext.Ajax.request({
														method: 'post',
														url: url+"app/C_rs_penyakit/update",
														waitTitle: 'Connecting',
														waitMsg: 'Sending data...',
														params: {
															kd_penyakit 			: win.items.items[0].value,
															parent 						: win.items.items[1].value,
															penyakit					: win.items.items[2].value,
															description 			: win.items.items[3].value,
															note 							: win.items.items[4].value,
															includes 					: win.items.items[5].value,
															exclude 					: win.items.items[6].value,
															status						: win.items.items[7].value,
															non_rujukan_flag	: win.items.items[8].value,
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
												thisForm.items.items[0].setDisabled(true);
												thisForm.items.items[0].setValue(index.data.kd_penyakit);
												thisForm.items.items[1].setValue(index.data.parent);
												thisForm.items.items[2].setValue(index.data.penyakit);
												thisForm.items.items[3].setValue(index.data.description);
												thisForm.items.items[4].setValue(index.data.note);
												thisForm.items.items[5].setValue(index.data.includes);
												thisForm.items.items[6].setValue(index.data.exclude);
												if (index.data.status == 1) {
													thisForm.items.items[7].setValue(true);
												}
												thisForm.items.items[7].setValue(index.data.status);
												if (index.data.non_rujukan_flag == 1) {
													thisForm.items.items[8].setValue(true);
												}
												thisForm.items.items[8].setValue(index.data.non_rujukan_flag);
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
