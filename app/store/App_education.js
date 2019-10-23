Ext.define('App.store.App_education', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    fields : [ 
        'id',
        'education',
        'active',
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_app_education/get',
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