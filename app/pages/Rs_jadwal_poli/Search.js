Ext.define('App.pages.Rs_jadwal_poli.Search', function(){
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
    return {
        extend : 'Ext.window.Window',
        title: 'Search',
        closable: true,
        width: 500,
        modal:false,
        constrain: true,
        plain: true,
        layout: 'form',
        bodyStyle: 'padding: 5px;',
        items: [
            {
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
          },
        ],
        initComponent:function(){
            Variable.getStorePoli('', null, null);
            Variable.getStoreEmployee('', null, null);
            this.callParent();
        },
    }
});