// new Ext.create('App.pages.App_user.List');
Ext.define('App.pages.App_user.employee.Lookup',{
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
        // Ext.create('App.pages.App_user.employee.List'),
    ]
});