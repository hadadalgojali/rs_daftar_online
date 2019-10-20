Ext.define('App.pages.Rs_customer.Migrate',function(){
    var Variable  = {};

    Variable.storeObjTablePrimary   = Ext.create('App.store.Table_structure');
    Variable.storeObjTableSecondary = Ext.create('App.store.Table_structure');
    Variable.storeCMBTablePrimary   = Ext.create('App.store.Table_structure');
    Variable.storeCMBTableSecondary = Ext.create('App.store.Table_structure');
    Variable.gridPrimary = null;
    Variable.gridSecond = null;

    Variable.getStorePrimary = function(params, start, limit){
      Variable.storeCMBTablePrimary.removeAll();
        Variable.storeCMBTablePrimary.load({
            params : {
                params      : params,
                start       : start,
                limit       : limit,
                table       : 'default',
            }
        });
    }

    Variable.getStoreSecond = function(params, start, limit){
      Variable.storeCMBTableSecondary.removeAll();
        Variable.storeCMBTableSecondary.load({
            params : {
                params      : params,
                start       : start,
                limit       : limit,
                table       : 'second',
            }
        });
    }

    var fields = [
       {name: 'column_name', mapping : 'column_name'},
    ];

    // var blankRecord =  Ext.data.Record.create(fields);
    var rEditor = Ext.create('Ext.grid.plugin.RowEditing', {
       clicksToEdit: 2,
    });

    var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
        clicksToEdit: 1
    });
    return{
      extend : 'Ext.window.Window',
      title: 'Form',
      closable: true,
      width: 600,
      modal:true,
      constrain: true,
      plain: true,
      layout: 'form',
      bodyStyle: 'padding: 0px;margin:0px;',
      items: [
        {
            xtype: 'panel',
            flex: 1,
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            border    : false,
            bodyStyle: 'padding: 0px;margin:0px;',
            items   : [
              {
                xtype   : 'grid',
                flex: 1,
          			store: Variable.storeObjTableSecondary,
                plugins: new Ext.grid.plugin.CellEditing({
                    clicksToEdit: 1
                }),
                selModel: {
                    selType: 'cellmodel'
                },
          			columns: [
          				{ header: 'Column Name',  dataIndex: 'column_name', flex : 1,
                    editor  :
                    {
                        xtype           : 'combo',
                        store           : Variable.storeCMBTableSecondary,
                        forceSelection  : false,
                        emptyText       : 'Select ...',
                        queryMode       : 'local',
                        displayField    : 'column_name',
                        valueField      : 'column_name',
                        anchor          : '100%',
                    },
                  },
                ],
                tbar  : [
                  {
                    xtype   : 'button',
                    iconCls : "fa fa-plus",
                    text    : "Tambah",
                    handler : function(){
                      Variable.storeObjTablePrimary.add(Ext.data.Record.create(fields));
                      Variable.storeObjTableSecondary.add(Ext.data.Record.create(fields));

                    }
                  }
                ]
              },
              {
                xtype   : 'label',
                width   : 10,
                text    : "",
                bodyStyle: 'padding: 0px;margin:5px;',
              },
                {
                  xtype   : 'grid',
                  flex: 1,
            			store: Variable.storeObjTablePrimary,
                  plugins: new Ext.grid.plugin.CellEditing({
                      clicksToEdit: 1
                  }),
                  selModel: {
                      selType: 'cellmodel'
                  },
            			columns: [
            				{ header: 'Column Name',  dataIndex: 'column_name', flex : 1,
                      editor  :
                      {
                          xtype           : 'combo',
                          store           : Variable.storeCMBTablePrimary,
                          forceSelection  : false,
                          emptyText       : 'Select ...',
                          queryMode       : 'local',
                          displayField    : 'column_name',
                          valueField      : 'column_name',
                          anchor          : '100%',
                      },
                    },
                  ],
                  tbar  : [
                    {
                      xtype   : 'button',
                      iconCls : "fa fa-plus",
                      text    : "Tambah",
                      handler : function(){
                        Variable.storeObjTablePrimary.add(Ext.data.Record.create(fields));
                        Variable.storeObjTableSecondary.add(Ext.data.Record.create(fields));
                      }
                    }
                  ]
                },
            ],
        }
      ],
    	initComponent:function(){
        Variable.getStorePrimary(" TABLE_NAME = 'rs_customer' ");
        Variable.getStoreSecond(" TABLE_NAME = 'customer' ");
        Variable.storeObjTablePrimary.removeAll();
        Variable.storeObjTableSecondary.removeAll();
    		this.callParent();
    	},
    }
});
