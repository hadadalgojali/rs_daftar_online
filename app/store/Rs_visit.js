Ext.define('App.store.Rs_visit', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    fields : [ 
        'no_pendaftaran', 
        'patient_code', 
        'name', 
        'unit_name', 
        'first_name', 
        'entry_date', 
        'no_antrian', 
        'status', 
        'hadir', 
        'jenis_daftar', 
        'customer_name', 
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_rs_visit/get',
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