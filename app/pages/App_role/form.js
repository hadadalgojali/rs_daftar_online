Ext.define('App.pages.App_role.form',{
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
        },
    ],
});