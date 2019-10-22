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
							Ext.create('App.pages.Rs_jadwal_poli.Form', {
								fbar    : [
									{
										xtype   : 'button',
										text    : 'Save',
										handler : function(btn){
											var win = btn.up('window'), form = win.down('form');
											var tmp_gender = 0;
											/*
												win.items.items[0] == id
												win.items.items[1] == combo unit
												win.items.items[2] == combo employee
												win.items.items[3] == combo day
												win.items.items[4] == jam mulai
												win.items.items[5] == jam akhir
												win.items.items[6] == Durasi periksa
												win.items.items[7] == Aktif
											*/
											Ext.Ajax.request({
												method: 'post',
												url: url+"app/C_rs_jadwal_poli/save",
												waitTitle: 'Connecting',
												waitMsg: 'Sending data...',
												params: {
													id 				: win.items.items[0].value,
													unit_id 		: win.items.items[1].value,
													employee_id		: win.items.items[2].value,
													day 			: win.items.items[3].value,
													start			: win.items.items[4].value,
													end 			: win.items.items[5].value,
													max				: win.items.items[6].value,
													duration		: win.items.items[7].value,
													active			: win.items.items[8].value,
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
							Variable.paramsCriteria = "";
							Variable.getStore(Variable.paramsCriteria, 0, 25);
						}
					},
					{
						text		: 'Search',
						iconCls		: 'fa fa-search fa-lg',
						iconAlign	: 'top',
						disabled 	: false,
						handler 	: function(a) {
							Ext.create('App.pages.Rs_jadwal_poli.Search',{
								title   : "Search",
								fbar    : [
									{
										xtype   : 'button',
										text    : 'Search',
										handler : function(btn){
											var win    = btn.up('window'), form = win.down('form');
											Variable.paramsCriteria = "";

												if (win.items.items[0].value != undefined && win.items.items[0].value != "") {
													// if (win.items.items[0].value != "") {
														if (Variable.paramsCriteria != "") {
															Variable.paramsCriteria += " AND ";
														}
														Variable.paramsCriteria += " rs_jadwal_poli.unit_id = '"+win.items.items[0].lastValue+"'";
													// }
												}
												if (win.items.items[1].value != undefined && win.items.items[1].value != "") {
													// if (win.items.items[1].value != "") {
														if (Variable.paramsCriteria != "") {
															Variable.paramsCriteria += " AND ";
														}
														Variable.paramsCriteria += " rs_jadwal_poli.dokter_id = '"+win.items.items[0].lastValue+"'";
													// }
												}

												console.log(Variable.paramsCriteria);
												Variable.getStore(Variable.paramsCriteria, 0, 25);
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
										tmp_id.push(item.data.id_jadwal_poli);
									});
									Ext.MessageBox.confirm('Delete', 'Apa anda yakin untuk menghapus ?', function(btn){
										if(btn === 'yes'){
											Ext.Ajax.request({
												method      : 'post',
												url         : url+"app/C_rs_jadwal_poli/delete",
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
							{ header: 'Klinik',  dataIndex: 'unit_name', width : 120,  editor : 'textfield'},
							{ header: 'Dokter',  dataIndex: 'first_name', width : 120,  editor : 'textfield'},
							{ header: 'Hari',  dataIndex: 'hari', flex : 1,  editor : 'textfield'},
							{ header: 'Jam Mulai',  dataIndex: 'start', flex : 1,  editor : 'textfield'},
							{ header: 'Jam Akhir',  dataIndex: 'end', flex : 1,  editor : 'textfield'},
							{ header: 'Max Pasien',  dataIndex: 'max_pelayanan', flex : 1,  editor : 'textfield'},
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
									Ext.create('App.pages.Rs_jadwal_poli.Form', {
										fbar    : [
											{
												xtype   : 'button',
												text    : 'Update',
												handler : function(btn){
													var win = btn.up('window'), form = win.down('form');
													Ext.Ajax.request({
														method: 'post',
														url: url+"app/C_rs_jadwal_poli/update",
														waitTitle: 'Connecting',
														waitMsg: 'Sending data...',
														params: {
															id 				: win.items.items[0].value,
															unit_id 		: win.items.items[1].value,
															employee_id		: win.items.items[2].value,
															day 			: win.items.items[3].value,
															start			: win.items.items[4].value,
															end 			: win.items.items[5].value,
															max				: win.items.items[6].value,
															duration		: win.items.items[7].value,
															active			: win.items.items[8].value,
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
												thisForm.items.items[0].setValue(index.data.id_jadwal_poli);
												thisForm.items.items[1].setValue(index.data.unit_id);
												thisForm.items.items[2].setValue(index.data.dokter_id);
												thisForm.items.items[3].setValue(index.data.hari);
												thisForm.items.items[4].setValue(index.data.start);
												thisForm.items.items[5].setValue(index.data.end);
												thisForm.items.items[6].setValue(index.data.max_pelayanan);
												thisForm.items.items[7].setValue(index.data.durasi_periksa);
												if (index.data.active_flag == 1) {
													thisForm.items.items[8].setValue(true);
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
