var App_employee    = {};
App_employee.storeAppJob    = Ext.create('App.store.App_job');
App_employee.getStoreAppJob = function(params, start, limit){
    App_employee.storeAppJob.load({
        params : {
            params  : params,
            start   : start,
            limit   : limit,
        }
    });
};

Ext.define('App.pages.App_employee.form',{
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
            fieldLabel  : 'Name',
        },{
            xtype: 'radiogroup',
            fieldLabel: 'Gender',
            items: [
                {
                    xtype   : 'radiofield',
                    boxLabel: 'Laki-laki',
                    name    : 'gender',
                    checked : true,
                },
                {
                    xtype   : 'radiofield',
                    boxLabel: 'Perempuan',
                    name    : 'gender',
                }
            ]
        },{
            xtype       : 'datefield',
            fieldLabel  : 'Birthday',
            format      : 'Y-m-d',
        },{
            xtype           : 'combo',
            store           : App_employee.storeAppJob,
            forceSelection  : false,
            valueField      : "job_id",
            emptyText       : 'Select ...',
            displayField    : "job_name",
            fieldLabel      : "Jobdesk",
            queryMode       : 'local',
            listeners       : {
                afterrender : function(){
                    App_employee.getStoreAppJob(" active_flag = 1 ", null, null);
                },
                change      : function(a, b){

                }
            }
        },{
            xtype       : 'textareafield',
            anchor      : '100%',
            fieldLabel  : 'Address'
        }
    ],
});