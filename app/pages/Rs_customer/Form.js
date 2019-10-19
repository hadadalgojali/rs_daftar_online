Ext.define('App.pages.Rs_customer.Form',function(){
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
          },
          {
              xtype       : 'textfield',
              fieldLabel  : 'Customer Code',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Customer Name',
          },{
              xtype: 'checkboxfield',
              anchor: '100%',
              fieldLabel: 'Active',
              boxLabel: ''
          }
      ],
    	initComponent:function(){
    		this.callParent();
    	},
    }
});
