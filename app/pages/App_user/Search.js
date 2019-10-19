Ext.define('App.pages.App_role.Search',{
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
            xtype       : 'textfield',
            fieldLabel  : 'Role Code',
        },{
            xtype       : 'textfield',
            fieldLabel  : 'Role Name',
        },
    ],
});