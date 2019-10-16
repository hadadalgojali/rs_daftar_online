// new Ext.create('App.pages.App_user.List');
Ext.define('App.pages.App_user.Lookup',{
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
            xtype: 'basicGrid',
            title: "Grid with Cell Editing and D'n'D reordering",
            // viewConfig: {
            //     plugins: {
            //         ptype: 'gridviewdragdrop',
            //         dragGroup: 'firstGridDDGroup',
            //         dropGroup: 'firstGridDDGroup'
            //     },
            //     listeners: {
            //         drop: function(node, data, dropRec, dropPosition) {
            //             var dropOn = dropRec ? ' ' + dropPosition + ' ' + dropRec.get('company') : ' on empty view';
            //             Ext.Msg.alert("Drag from right to left", 'Dropped ' + data.records[0].get('company') + dropOn);
            //         }
            //     }
            // }
        },
    ]
});