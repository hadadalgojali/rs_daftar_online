Ext.define('App.store.Rs_customer', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    fields : [
        'customer_id',
        'customer_name',
        'customer_code',
        'active_flag',
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_rs_customer/get',
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
