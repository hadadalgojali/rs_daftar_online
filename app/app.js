Ext.application({
	name : 'App',
	launch : function() {
		Ext.getBody().mask('Authentication');
		Ext.Ajax.request({
			url : url + 'Auth/get_session',
			method : 'GET',
			success : function(response) {
				if (response.status == 200) {
					var obj = Ext.decode(response.responseText);
					session.user = obj;

					Ext.Ajax.request({
						url : url + 'Auth/get_menu',
						method : 'GET',
						success : function(response) {
							if (response.status == 200) {
								var obj = Ext.decode(response.responseText);
								session.menu = obj.menu;
								Ext.create('App.system.Main');
							}
							Ext.getBody().unmask();
						}
					});
				}
			}
		});
	}
});
var tabVar={};