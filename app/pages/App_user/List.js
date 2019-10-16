Ext.define('App.pages.App_user.List', function() {
    return {
        extend: 'Ext.grid.Panel',
        xtype: 'GridEmployee',
        store: 'Company',
        title: 'Basic Grid',
        plugins: {
            ptype: 'cellediting'
        },
        columns: [
            { text: 'Company', flex: 1, dataIndex: 'company', editor: 'textfield' },
            { text: 'Price', width: 75, sortable: true, renderer: 'usMoney', dataIndex: 'price', editor: 'numberfield' },
            { text: 'Change', width: 75, sortable: true,  dataIndex: 'change', editor: 'numberfield' },
            { text: '% Change', width: 75, sortable: true,  dataIndex: 'pctChange', editor: 'numberfield' },
            { text: 'Last Updated', width: 85, sortable: true, renderer: Ext.util.Format.dateRenderer('m/d/Y'), dataIndex: 'lastChange', editor: 'datefield' },
        ]
    };
});