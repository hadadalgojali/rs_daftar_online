Ext.define('App.pages.Rs_patient.Main', function(){
	var Variable = {};
	let http = new XMLHttpRequest();
	let url_migrate = url+'Structure/migrate_data';
	Variable.storeobj = Ext.create('App.store.Rs_patient');
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
	Variable.wait = function(ms) {
		return new Promise(r => setTimeout(r, ms));
	}

	Variable.XHRpost = function(i, params, panel) {
		return new Promise(function(resolve) {
			http.open('POST', url_migrate, true);
			http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			http.onreadystatechange = function() {
				if(http.readyState == 4){
					var tmp_done = panel.dockedItems.items[1].items.items[0].getValue();
					tmp_done = tmp_done.split("/");
					tmp_done[0] = (i+1);
					panel.dockedItems.items[1].items.items[0].setValue(tmp_done[0]+"/"+tmp_done[1]);
					var nilai_1 = parseInt(tmp_done[0]);
					var nilai_2 = parseInt(tmp_done[1]);
					var hasil 	= 0;
					parseFloat(hasil);
					hasil = nilai_1/nilai_2;

					panel.items.items[0].setValue(hasil);
					resolve();
				}
			}
			http.send(params);     
		});
	}

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
							Ext.create('App.pages.Rs_patient.Form', {
								fbar    : [
									{
										xtype   : 'button',
										text    : 'Save',
										handler : function(btn){
											var win = btn.up('window'), form = win.down('form');
											var form_1 = win.items.items[0].items.items[0].items;
											var form_2 = win.items.items[0].items.items[1].items;
											var tmp_gender = 1;

											if (form_1.items[6].items.items[0].value === false) {
												tmp_gender = 0;
											}
											Ext.Ajax.request({
												method: 'post',
												url: url+"app/C_rs_patient/save",
												waitTitle: 'Connecting',
												waitMsg: 'Sending data...',
												params: {
													patient_id 		: form_1.items[0].value,
													patient_code 	: form_1.items[1].value,
													title 			: form_1.items[2].value,
													name 			: form_1.items[3].value,
													birth_place		: form_1.items[4].value,
													birth_date		: form_1.items[5].value,
													address			: form_1.items[7].value,
													telepon			: form_1.items[8].value,
													pos_code		: form_1.items[9].value,
													gender 			: tmp_gender,

													religion_id		: form_2.items[0].value,
													education_id	: form_2.items[1].value,
													jobdesk_id		: form_2.items[2].value,
													country_id		: form_2.items[3].value,
													province_id		: form_2.items[4].value,
													district_id		: form_2.items[5].value,
													districts_id	: form_2.items[6].value,
													kelurahan_id	: form_2.items[7].value,
												},
												success: function(res){
													var cst = JSON.parse(res.responseText);
													Ext.Msg.alert("Informasi", ""+cst.message+"");
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
								listeners 	: {
									show 	: function(thisForm){
									var form_1 = thisForm.items.items[0].items.items[0].items;
	                                  Ext.Ajax.request({
	                                    method    : 'post',
	                                    url       : url+"app/C_rs_patient/get_last_medrec",
	                                    waitTitle : 'Connecting',
	                                    waitMsg   : 'Sending data...',
	                                    params    : {
	                                      id  : null
	                                    },
	                                    success: function(res){
											var cst = JSON.parse(res.responseText);
											// a.setValue(cst.medrec);
											form_1.items[1].setValue(cst.medrec);
	                                    },
	                                    failure: function(){
	                                      console.log('failure');
	                                    }
	                                  });
									}
								}
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
										tmp_id.push(item.data.patient_id);
									});
									Ext.MessageBox.confirm('Delete', 'Apa anda yakin untuk menghapus ?', function(btn){
										if(btn === 'yes'){
											Ext.Ajax.request({
												method      : 'post',
												url         : url+"app/C_rs_patient/delete",
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
					},{
						xtype		: 'buttongroup',
						columns		: 2,
						title		: 'Export',
						bodyStyle	: 'margin:0px;margin-right:10px;padding:0px;',
						style		: 'margin:0px;margin-right:10px;padding:0px;',
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
					},{
						xtype		: 'buttongroup',
						columns		: 2,
						title		: 'Data',
						bodyStyle	: 'margin:0px;margin-right:10px;padding:0px;',
						style		: 'margin:0px;margin-right:10px;padding:0px;',
						items: [
							{
								text			: 'Migrate',
								iconCls		: 'fa fa-exchange fa-lg',
								iconAlign	: 'top',
								handler 	: function(a) {
									Ext.create('App.pages.Rs_patient.Migrate', {
										fbar 	: [
						                    {
												xtype   : "button",
												text    : "Migrate",
												handler : function(btn){
													var win               = btn.up('window');
													var data_grid_second  = win.items.items[0].items.items[0].items.items[0].store.data.items;
													var data_grid_default = win.items.items[0].items.items[2].items.items[0].store.data.items;
													var result 			 	= true;
													var variabel = {};
													variabel.second 	= [];
													variabel.default 	= [];

													for (var i = 0; i < data_grid_second.length; i++) {
														if (data_grid_second[i].data.column_name == null || data_grid_second[i].data.column_name == undefined) {
															Ext.Msg.alert("Informasi", "Ada field yg kosong");
															result = false;
															break;
														}
													}

													for (var i = 0; i < data_grid_default.length; i++) {
														if (data_grid_default[i].data.column_name == null || data_grid_default[i].data.column_name == undefined) {
															Ext.Msg.alert("Informasi", "Ada field yg kosong");
															result = false;
															break;
														}
													}

													for (var i = 0; i < data_grid_second.length; i++) {
														if (data_grid_second[i].data.column_name !== null && data_grid_second[i].data.column_name !== undefined) {
															variabel.second.push(data_grid_second[i].data.column_name);
														}
													}

													for (var i = 0; i < data_grid_default.length; i++) {
														if (data_grid_default[i].data.column_name !== null && data_grid_default[i].data.column_name !== undefined) {
															variabel.default.push(data_grid_default[i].data.column_name);
														}
													}
													
													if (result === true) {
														Ext.Ajax.request({
															method: 'post',
															url: url+"Structure/count_migrate",
															waitTitle: 'Connecting',
															waitMsg: 'Sending data...',
															params: {
																second 			: JSON.stringify(variabel.second),
																default 		: JSON.stringify(variabel.default),
																db_second 		: 'pasien',
																db_default 		: 'rs_patient',
																field 			: 'kd_pasien',
															},
															success: function(res){
																var cst = JSON.parse(res.responseText);
																// Ext.Msg.alert("Update", ""+cst.message+"");
																// Variable.getStore(Variable.paramsCriteria, 0, 25);
																if (cst.code == 200) {
																	win.close();
																	Ext.create('App.pages.Rs_patient.Process_migrate',{
																		fbar 	: [
																			{
																				xtype 	: 'textfield',
																				readOnly: true,
																			},
																			{
																				xtype 	: 'button',
																				text 	: 'Migrate',
																				handler : function(btn){
																					var win = btn.up('window');
																					console.log(win);
																					try{
																						// for (var i = 0; i < cst.data.length; i++) {
																							// (async () => {
																								// let rawResponse = await fetch(url+'Structure/migrate_data', {
																									// method: 'POST',
																									// body: JSON.stringify({
																										// field: 'kd_pasien', 
																										// id: cst.data[i].id, 
																										// db_second : 'pasien',
																										// db_default : 'rs_patient',
																									// })
																								// });
																								// rawResponse     = await rawResponse.json();
																								// Variable.wait(3000);
																								// console.log(rawResponse);
																							// })();
																						// }
																						var tmp_params_sec = "";
																						for (var i = 0; i < variabel.second.length; i++) {
																							tmp_params_sec += "'"+variabel.second[i]+"',";
																						}
																						tmp_params_sec = tmp_params_sec.substring(0, tmp_params_sec.length - 1);

																						var tmp_params_def = "";
																						for (var i = 0; i < variabel.default.length; i++) {
																							tmp_params_def += "'"+variabel.default[i]+"',";
																						}
																						tmp_params_def = tmp_params_def.substring(0, tmp_params_def.length - 1);


																						(async () => {
																							for (var i = 0; i < cst.data.length; i++) {
																								var tmp_params = "";
																								tmp_params = "key_second=kd_pasien&key_first=patient_code&id="+cst.data[i].id+"&db_second=pasien&db_default=rs_patient&field_second="+tmp_params_sec+"&field_first="+tmp_params_def;
																								await Variable.XHRpost(i, tmp_params, win);
																							}
																						})();

																					}catch (error) {
																						console.log(error);
																					}
																				}
																			}
																		],
																		listeners: {
																			show: function(thisForm){
																				console.log(thisForm);
																				thisForm.dockedItems.items[1].items.items[0].setValue("0/"+cst.count);
																				// thisForm.items.items[0].setValue("0/"+cst.count);
																			},
																		}
																	}).show()
																}
															},
															failure: function(){
																console.log('failure');
															}
														});
													}
												}
											},{
												xtype 	: 'button',
												text 	  : 'close',
												handler : function(btn){
													var win = btn.up('window');
													win.close();
												}
											}
										]
									}).show();
								}
							},
						]
					}
				],
				items : [
					Variable.grid = Ext.create('Ext.grid.Panel', {
						store: Variable.storeobj,
						selModel: Ext.create('Ext.selection.CheckboxModel'),
						columns: [
							{ header: 'Medrec',  dataIndex: 'patient_code', width : 120,  editor : 'textfield'},
							{ header: 'Nama',  dataIndex: 'name', flex : 1,  editor : 'textfield'},
							{ header: 'Alamat ',  dataIndex: 'address', flex : 1,  editor : 'textfield'},
							{ header: 'Telepon',  dataIndex: 'phone_number', width : 120,  editor : 'textfield'},
							{ header: 'Tgl Lahir',  dataIndex: 'birth_date', width : 120,  editor : 'textfield'},
			                {
			                    header: 'Kelamin',
			                    dataIndex: 'gender',
			                    width : 120,
			                    renderer    : function(a){
			                        if (a == 0) {
			                            return "Perempuan";
			                        }else{
			                            return "Laki-laki";
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
									Ext.create('App.pages.Rs_patient.Form', {
										fbar    : [
											{
												xtype   : 'button',
												text    : 'Update',
												handler : function(btn){
													var win = btn.up('window'), form = win.down('form');
													var form_1 = win.items.items[0].items.items[0].items;
													var form_2 = win.items.items[0].items.items[1].items;
													var tmp_gender = 1;

													if (form_1.items[6].items.items[0].value === false) {
														tmp_gender = 0;
													}

													Ext.Ajax.request({
														method: 'post',
														url: url+"app/C_rs_patient/update",
														waitTitle: 'Connecting',
														waitMsg: 'Sending data...',
														params: {
															patient_id 		: form_1.items[0].value,
															patient_code 	: form_1.items[1].value,
															title 			: form_1.items[2].value,
															name 			: form_1.items[3].value,
															birth_place		: form_1.items[4].value,
															birth_date		: form_1.items[5].value,
															address			: form_1.items[7].value,
															telepon			: form_1.items[8].value,
															pos_code		: form_1.items[9].value,
															gender 			: tmp_gender,

															religion_id		: form_2.items[0].value,
															education_id	: form_2.items[1].value,
															jobdesk_id		: form_2.items[2].value,
															country_id		: form_2.items[3].value,
															province_id		: form_2.items[4].value,
															district_id		: form_2.items[5].value,
															districts_id	: form_2.items[6].value,
															kelurahan_id	: form_2.items[7].value,
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
												var form_1 = thisForm.items.items[0].items.items[0].items;
												var form_2 = thisForm.items.items[0].items.items[1].items;

												if (index.data.gender == '0' || index.data.gender == 0) {
													form_1.items[6].items.items[1].setValue(true);
												}
												form_1.items[0].setValue(index.data.patient_id);
												form_1.items[1].setValue(index.data.patient_code);
												form_1.items[2].setValue(index.data.title);
												form_1.items[3].setValue(index.data.name);
												form_1.items[4].setValue(index.data.birth_place);
												form_1.items[5].setValue(index.data.birth_date);
												form_1.items[7].setValue(index.data.address);
												form_1.items[8].setValue(index.data.phone_number);
												form_1.items[9].setValue(index.data.postal_code);


												form_2.items[0].setValue(index.data.religion_id);
												form_2.items[1].setValue(index.data.education_id);
												form_2.items[2].setValue(index.data.jobdesk_id);
												form_2.items[3].setValue(index.data.country_id);
												form_2.items[4].setValue(index.data.province_id);
												form_2.items[5].setValue(index.data.district_id);
												form_2.items[6].setValue(index.data.districts_id);
												form_2.items[7].setValue(index.data.kelurahan_id);
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
