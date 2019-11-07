Ext.define('App.pages.Rs_patient.Process_migrate',function(){
    var Variable  = {};
    return{
      extend : 'Ext.window.Window',
      title: 'Form',
      closable: true,
      width: 500,
      modal:true,
      constrain: true,
      plain: true,
      layout: 'form',
      bodyStyle: 'padding: 5px;margin:0px;',
      items: [
        {
            xtype: 'progressbar',
            value: 0.4
        },
      ],
    	initComponent:function(){
    		this.callParent();
    	},
    }
});
