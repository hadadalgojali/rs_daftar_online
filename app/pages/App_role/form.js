Ext.define('App.pages.App_role.form',function(){
    var FormAppRole = {};
    FormAppRole.storeObjTenant  = Ext.create('App.store.App_tenant');
    FormAppRole.getStoreTenant  = function(params, start, limit){
        FormAppRole.storeObjTenant.removeAll();
        FormAppRole.storeObjTenant.load({
            params : {
                params      : params,
                start       : start,
                limit       : limit,
            }
        });
    }

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
              fieldLabel  : 'Role Code',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Role Name',
          },{
              xtype       : 'textarea',
              fieldLabel  : 'Description',
          },{
              xtype           : 'combo',
              store           : FormAppRole.storeObjTenant,
              forceSelection  : false,
              valueField      : "tenant_id",
              emptyText       : 'Select ...',
              displayField    : "tenant_name",
              fieldLabel      : "Tenant",
              queryMode       : 'local',
              anchor          : '100%',
              listeners       : {
                  change      : function(a, b){
                    
                  }
              }
          },{
              xtype: 'checkboxfield',
              anchor: '100%',
              fieldLabel: 'Active',
              boxLabel: ''
          }
      ],
    	initComponent:function(){
    		this.callParent();
        FormAppRole.getStoreTenant("", null, null);
    	},
    }
});
