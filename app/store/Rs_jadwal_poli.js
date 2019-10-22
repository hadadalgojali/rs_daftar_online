Ext.define('App.store.Rs_jadwal_poli', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    pageSize: 25,
    fields : [
      'id_jadwal_poli',
      'dokter_id',
      'unit_id',
      'hari',
      'start',
      'end',
      'max_pelayanan',
      'durasi_periksa',
      'klinik',
      'dokter',
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_rs_jadwal_poli/get',
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
