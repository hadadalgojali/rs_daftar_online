Ext.define('App.store.Table_structure', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    fields : [
        'column_name',
        'data_type',
    ],
    pageSize: 25,
    proxy: {
        type: 'ajax',
        url: url+'Structure/get',
        reader: {
            successProperty: 'success', // if success property
            type: 'json',
            root: 'results', // if root

            // THIS IS THE FUNCTION YOU NEED TO MANIPULATE THE DATA
            getData: function(data){
                Ext.each(data.results, function(rec) {
                    // console.log(rec);
                    // var access = rec.access;
                });

                // console.log(data);
                return data;
            }
        },
        writer: {
            type: 'json'
        }
    }
});
