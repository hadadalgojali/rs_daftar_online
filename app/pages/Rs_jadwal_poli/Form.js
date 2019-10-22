Ext.define('App.pages.Rs_unit.Form',function(){
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
              xtype           : 'combo',
          		store : new Ext.data.SimpleStore({
          			data : [
                  [0, 'UNITTYPE_UGD'],
                  [1, 'UNITTYPE_RWJ'],
                  [2, 'UNITTYPE_RWI'],
                  [3, 'UNITTYPE_LAB'],
                  [4, 'UNITTYPE_RAD'],
                  [5, 'UNITTYPE_PEN'],
                ],
          			id : 0,
          			fields : ['value', 'text']
          		}),
              forceSelection  : false,
              valueField      : "text",
              emptyText       : 'Select ...',
              displayField    : "text",
              fieldLabel      : "Unit Type",
              queryMode       : 'local',
              anchor          : '100%',
              listeners       : {
                  change      : function(a, b){

                  }
              }
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Unit Code',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Unit Name',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Code BPJS',
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
