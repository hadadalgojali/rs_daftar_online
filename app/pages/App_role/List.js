Ext.define('App.pages.Role.List',{
	extend:'App.cmp.Table',
	id:'a3.list',
	params:function(){
		// return Ext.getCmp('a3.search.panel').qParams();
	},
	url:url + 'app/C_app_role/get',
	result:function(response){
		// if(session.tenant == null){
		// 	Ext.getCmp('a3.list').columns[1].setVisible(true);
		// }
		return {list:response.data,total:response.total};
	},
	columns:[
		{xtype: 'rownumberer'},
		{ text: 'Tenant',width: 150,hideable:false, sortable :false,hidden:true, dataIndex: 'tenant_name' },
		{ hidden:true, hideable:false,dataIndex: 'tenant_id' },
		{ hidden:true, hideable:false,dataIndex: 'id' },
		{ text: 'Role Code',width: 100, dataIndex: 'role_code'},
		{ text: 'Role Name',width: 150, dataIndex: 'role_name'},
		{ text: 'Description',width: 150,dataIndex: 'description', flex: 1 },
		{ text: 'Active',width: 50,sortable :false,dataIndex: 'active_flag',align:'center',
			renderer: function(value){
				if(value==true)
					return '<img src="' + icon('t') + '" style="margin: -5px;" />';
				else
					return '<img src="' + icon('f') + '" style="margin: -5px;" />';
			}
		},
	]
});