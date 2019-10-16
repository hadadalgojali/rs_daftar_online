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
                {
                    xtype           : 'fieldcontainer',
                    fieldLabel      : 'Employee',
                    layout          : 'hbox',
                    defaults        : {
                        anchor      : '100%',
                        hideLabel   : true
                    },
                    items: [
                        {
                            xtype: 'textfield',
                        },
                        {
                            xtype: 'button',
                            html    : '<i class="fa fa-search"></i>',
                            handler : function(){
                                Ext.create('App.pages.App_user.employee.Lookup', {
                                    fbar    : [
                                        {
                                            xtype   : 'button',
                                            text    : 'Keluar',
                                            handler : function(btn){
                                                var win = btn.up('window');
                                                win.close();
                                            }
                                        }
                                    ]
                                }).show();
                            }
                        }
                    ]
                },
                {
                    xtype: 'textfield',
                    anchor: '100%',
                    fieldLabel: 'Password'
                },
                {
                    xtype: 'textfield',
                    anchor: '100%',
                    fieldLabel: 'Re-password'
                },
                {
                    xtype: 'combobox',
                    anchor: '100%',
                    fieldLabel: 'Role'
                },
                {
                    xtype: 'checkboxfield',
                    anchor: '100%',
                    fieldLabel: 'Active',
                    boxLabel: ''
                }
            ]
        }
    ]
});