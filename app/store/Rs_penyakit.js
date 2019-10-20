Ext.define('App.store.Rs_penyakit', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    pageSize: 25,
    fields : [
      'kd_penyakit',
      'parent',
      'penyakit',
      'includes',
      'exclude',
      'note',
      'status',
      'description',
      'non_rujukan_flag',
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_rs_penyakit/get',
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
