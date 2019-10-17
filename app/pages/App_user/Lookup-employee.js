var pageAppLookUp_RoleEmploye = {};
pageAppLookUp_RoleEmploye.storeobj = Ext.create('App.store.App_employee');
pageAppLookUp_RoleEmploye.getStore = function(params, start, limit){
    pageAppLookUp_RoleEmploye.storeobj.removeAll();
    pageAppLookUp_RoleEmploye.storeobj.load({
        params : {
            params      : params,
            start       : start,
            limit       : limit,
        }
    });
}

pageAppLookUp_RoleEmploye.paramsCriteria  = '';
Ext.define('App.pages.App_user.Lookup-employee',{
    extend : 'Ext.window.Window',
    title: 'List Employee',
    closable: true,
    width: 500,
    requires: [
        'Ext.grid.Panel',
        'Ext.view.Table'
    ],
    modal:true,
    constrain: true,
    plain: true,
    bodyStyle   : 'padding: 0px;margin: 0px;',
    style       : 'padding: 0px;margin: 0px;',
    items: [
        {
            xtype   : 'gridpanel',
            store   : pageAppLookUp_RoleEmploye.storeobj,
            columns: [
                {
                    xtype       : 'gridcolumn',
                    dataIndex   : 'first_name',
                    text        : 'Name',
                    flex        : 1,
                },
                {
                    xtype       : 'gridcolumn',
                    dataIndex   : 'birthdate',
                    text        : 'Birth date',
                    flex        : 1,
                },
                {
                    xtype       : 'gridcolumn',
                    dataIndex   : 'address',
                    text        : 'Address',
                    flex        : 1,
                },
                {
                    xtype       : 'gridcolumn',
                    dataIndex   : 'email_address',
                    text        : 'Email',
                    flex        : 1,
                }
            ],
            viewConfig: {
                listeners: {
                    itemclick: function(dataview, index, item, e) {
                        pageAppUser_Form.list_employee = index.data;
                    }
                }
            }
        }
    ],
    listeners  : {
        show : function(){
            pageAppLookUp_RoleEmploye.getStore(pageAppLookUp_RoleEmploye.paramsCriteria, 0, 25);
        }
    }
});