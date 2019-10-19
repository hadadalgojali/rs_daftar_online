Ext.define('App.pages.Home', {
	extend 		: 'App.cmp.Panel',
	title 		: '',
	id 			: 'main.tab.home',
	bodyStyle	: 'margin:0px;padding:0px;',
	style		: 'margin:0px;padding:0px;',
	iconCls 	: 'fa fa-home fa-lg',
	tbar 		: [{
	    xtype		: 'buttongroup',
	    columns		: 3,
	    title		: 'User Menu',
		bodyStyle	: 'margin:0px;padding:0px;',
		style		: 'margin:0px;padding:0px;',
	    items: [
	    	{
	            text		: 'Profile',
	            iconCls		: 'fa fa-user fa-lg',
	            id			: 'home.btnProfile',
	            iconAlign	: 'top',
	            handler 	: function(a) {
	            }
	        },
	    	{
	            text		: 'Logout',
	            iconCls		: 'fa fa-power-off fa-lg',
	            id			: 'home.btnLogout',
	            iconAlign	: 'top',
	            handler 	: function(a) {
	            }
	        }
	    ]
	}]
})