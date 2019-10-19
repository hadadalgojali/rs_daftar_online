Ext.define('App.store.Rs_unit', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    pageSize: 25,
    fields : [
      'unit_id',
      'unit_type',
      'unit_code',
      'unit_name',
      'active_flag',
      'kd_unit_bpjs',
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_rs_unit/get',
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
