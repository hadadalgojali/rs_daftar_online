var App_user_Form = {};
App_user_Form.storeobj = Ext.create('App.store.App_role');
App_user_Form.getStore = function(params, start, limit){
    App_user_Form.storeobj.removeAll();
    App_user_Form.storeobj.load({
        params : {
            params      : ' app_role.active_flag = 1 '+params,
            start       : start,
            limit       : limit,
        }
    });
}

App_user_Form.paramsCriteria  = '';
Ext.define('App.pages.App_user.Form',{
    extend : 'Ext.window.Window',
    title: 'Form',
    closable: true,
    width: 500,
    modal:true,
    constrain: true,
    plain: true,
    layout: 'form',
    bodyStyle: 'padding: 0px;margin: 0px;',
    items: [
        {
            xtype: 'form',
            bodyPadding: 10,
            border  : false,
            items: [
                /*{
                    xtype           : 'fieldcontainer',
                    fieldLabel      : 'Employee',
                    layout          : 'hbox',
                    defaults        : {
                        anchor      : '100%',
                        hideLabel   : true
                    },
                    items: [
                        {
                            xtype       : 'textfield',
                            readOnly    : true,
                        },
                        {
                            xtype: 'button',
                            html    : '<i class="fa fa-search"></i>',
                            handler : function(){
                                Ext.create('App.pages.App_user.Lookup-employee', {
                                    fbar    : [
                                        {
                                            xtype   : 'button',
                                            text    : 'Pilih',
                                            handler : function(btn){
                                                var win = btn.up('window');
                                                win.close();
                                            }
                                        },{
                                            xtype   : 'button',
                                            text    : 'Keluar',
                                            handler : function(btn){
                                                var win = btn.up('window');
                                                win.close();
                                            }
                                        }
                                    ],
                                }).show();
                            }
                        }
                    ]
                },*/
                {
                    xtype: 'textfield',
                    anchor: '100%',
                    fieldLabel: 'Username'
                },{
                    xtype: 'checkbox',
                    fieldCls: 'toggleBox',
                    inputAttrTpl: 'value ="Click"',
                    fieldLabel  : "Change Pass ",
                    listeners   : {
                        change  : function(a, b, c,d){
                            var win = a.up('window'), form = win.down('form');

                            if (b === true) {
                                win.items.items[0].items.items[2].setDisabled(false);
                                win.items.items[0].items.items[3].setDisabled(false);
                            }else{
                                win.items.items[0].items.items[2].setDisabled(true);
                                win.items.items[0].items.items[3].setDisabled(true);
                            }
                        }
                    }
                },
                {
                    xtype       : 'textfield',
                    anchor      : '100%',
                    inputType   : 'password',
                    fieldLabel  : 'Password',
                    disabled    : true,
                },
                {
                    xtype       : 'textfield',
                    anchor      : '100%',
                    inputType   : 'password',
                    fieldLabel  : 'Re-password',
                    disabled    : true,
                },
                {
                    xtype           : 'combo',
                    store           : App_user_Form.storeobj,
                    forceSelection  : false,
                    valueField      : "role_id",
                    emptyText       : 'Select ...',
                    displayField    : "role_name",
                    fieldLabel      : "Role",
                    queryMode       : 'local',
                    anchor          : '100%',
                    listeners       : {
                        afterrender : function(){
                            App_user_Form.getStore("", null, null);
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
                }
            ]
        }
    ],
    listeners : {
        show    : function(){
            App_user_Form.getStore(App_user_Form.paramsCriteria, null, null);
        }
    }
});