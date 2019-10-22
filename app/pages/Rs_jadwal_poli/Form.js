Ext.define('App.pages.Rs_jadwal_poli.Form',function(){
    var Variable = {};
    Variable.storeObjPoli     = Ext.create('App.store.Rs_unit');
    Variable.storeObjEmployee = Ext.create('App.store.App_employee');
    Variable.getStorePoli = function(params, start, limit){
      Variable.storeObjPoli.removeAll();
        Variable.storeObjPoli.load({
            params : {
                params      : params,
                start       : start,
                limit       : limit,
            },
        });
    }

    Variable.getStoreEmployee = function(params, start, limit){
      Variable.storeObjEmployee.removeAll();
        Variable.storeObjEmployee.load({
            params : {
                params      : params,
                start       : start,
                limit       : limit,
            },
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
          },{
              xtype           : 'combo',
              store           : Variable.storeObjPoli,
              forceSelection  : false,
              valueField      : "unit_id",
              emptyText       : 'Select ...',
              displayField    : "unit_name",
              fieldLabel      : "Klinik",
              queryMode       : 'local',
              anchor          : '100%',
          },{
              xtype           : 'combo',
              store           : Variable.storeObjEmployee,
              forceSelection  : false,
              valueField      : "employee_id",
              emptyText       : 'Select ...',
              displayField    : "first_name",
              fieldLabel      : "Employee",
              queryMode       : 'local',
              anchor          : '100%',
          },{
              xtype           : 'combo',
              store : new Ext.data.SimpleStore({
                data : [
                  [0, 'Senin'],
                  [1, 'Selasa'],
                  [2, 'Rabu'],
                  [3, 'Kamis'],
                  [4, 'Jumat'],
                  [5, 'Sabtu'],
                  [6, 'Minggu'],
                ],
                id : 0,
                fields : ['value', 'text']
              }),
              forceSelection  : false,
              valueField      : "text",
              emptyText       : 'Select ...',
              displayField    : "text",
              fieldLabel      : "Hari",
              queryMode       : 'local',
              anchor          : '100%',
          },{
              xtype       : 'timefield',
              fieldLabel  : 'Jam Mulai',
          },{
              xtype       : 'timefield',
              fieldLabel  : 'Jam Akhir',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Max Daftar',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Durasi Periksa',
          },{
              xtype: 'checkboxfield',
              anchor: '100%',
              fieldLabel: 'Active',
              boxLabel: ''
          }
      ],
    	initComponent:function(){
        Variable.getStorePoli('', null, null);
        Variable.getStoreEmployee('', null, null);
    		this.callParent();
    	},
    }
});
