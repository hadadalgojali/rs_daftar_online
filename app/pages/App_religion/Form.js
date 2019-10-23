Ext.define('App.pages.App_religion.Form',function(){
    return{
      extend : 'Ext.window.Window',
      title: 'Form',
      closable: true,
      width: 500,
      modal:true,
      constrain: true,
      plain: true,
      layout: 'form',
      bodyStyle: 'padding: 5px;',
      items: [
          {
              xtype       : 'textfield',
              hidden      : true,
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Religion',
          },{
              xtype       : 'checkboxfield',
              anchor      : '100%',
              fieldLabel  : 'Active',
              boxLabel    : '',
              checked     : true,
          }
      ],
    	initComponent:function(){
    		this.callParent();
    	},
    }
});
