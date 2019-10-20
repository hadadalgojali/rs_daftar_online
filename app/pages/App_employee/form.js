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
App_employee.storeAppReligion    = Ext.create('App.store.App_religion');
App_employee.getStoreAppReligion = function(params, start, limit){
    App_employee.storeAppReligion.load({
        params : {
            params  : params,
            start   : start,
            limit   : limit,
        }
    });
};
App_employee.storeAppTenant    = Ext.create('App.store.App_tenant');
App_employee.getStoreAppTenant = function(params, start, limit){
    App_employee.storeAppTenant.load({
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
    // closable: true,
    width: 600,
    modal:true,
    constrain: true,
    plain: true,
    bodyStyle: 'padding: 0px;margin: 0px;',
    layout: {
        type: 'vbox',
        align: 'stretch'
    },
    items: [
        {
            xtype: 'panel',
            flex: 1,
            title: 'General Data',
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            bodyStyle: 'padding: 0px;margin: 0px;',
            items: [
                {
                    xtype: 'form',
                    flex: 1,
                    bodyPadding: 10,
                    items: [
                        {
                            xtype       : 'textfield',
                            anchor      : '100%',
                            fieldLabel  : 'Employee id',
                            hidden      : true,
                        },
                        {
                            xtype       : 'textfield',
                            anchor      : '100%',
                            fieldLabel  : 'ID Card',
                        },
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            fieldLabel: 'Firstname'
                        },
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            fieldLabel: 'Lastname'
                        },
                        {
                            xtype: 'radiogroup',
                            fieldLabel: 'Gender',
                            items: [
                                {
                                    xtype: 'radiofield',
                                    boxLabel: 'Laki-laki',
                                    name       : 'gender',
                                },
                                {
                                    xtype: 'radiofield',
                                    boxLabel: 'Perempuan',
                                    name       : 'gender',
                                }
                            ]
                        },
                        {
                            xtype           : 'combo',
                            store           : App_employee.storeAppReligion,
                            forceSelection  : false,
                            valueField      : "id",
                            emptyText       : 'Select ...',
                            displayField    : "religion",
                            fieldLabel      : "Religion",
                            queryMode       : 'local',
                            anchor          : '100%',
                            listeners       : {
                                afterrender : function(){
                                    App_employee.getStoreAppReligion(" active = 1 ", null, null);
                                },
                                change      : function(a, b){

                                }
                            }
                        },
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            fieldLabel: 'Birth place'
                        },
                        {
                            xtype       : 'datefield',
                            anchor      : '100%',
                            fieldLabel  : 'Birth date',
                            format      : 'Y-m-d',
                        },
                        {
                            xtype: 'textareafield',
                            anchor: '100%',
                            fieldLabel: 'Address'
                        }
                    ]
                },
                {
                    xtype: 'form',
                    flex: 1,
                    bodyPadding: 10,
                    items: [
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            fieldLabel: 'Email'
                        },
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            fieldLabel: 'Phone number 1'
                        },
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            fieldLabel: 'Phone number 2'
                        },
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            fieldLabel: 'Fax'
                        }
                    ]
                }
            ]
        }
    ],
    dockedItems: [
        {
            xtype: 'panel',
            flex: 1,
            dock: 'bottom',
            title: 'Other',
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            items: [
                {
                    xtype: 'form',
                    flex: 1,
                    bodyPadding: 10,
                    items: [
                        {
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
                        },
                        {
                            xtype: 'checkboxfield',
                            anchor: '100%',
                            fieldLabel: 'Active',
                            boxLabel: ''
                        },
                            {
                                xtype           : 'combo',
                                store           : App_employee.storeAppTenant,
                                forceSelection  : false,
                                valueField      : "tenant_id",
                                emptyText       : 'Select ...',
                                displayField    : "tenant_name",
                                fieldLabel      : "Tenant",
                                queryMode       : 'local',
                                listeners       : {
                                    afterrender : function(){
                                        App_employee.getStoreAppTenant(" active_flag = 1 ", null, null);
                                    },
                                    change      : function(a, b){

                                    }
                                }
                            },
                    ]
                }
            ]
        }
    ],
});
