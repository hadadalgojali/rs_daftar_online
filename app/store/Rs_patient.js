Ext.define('App.store.Rs_patient', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    pageSize: 25,
    fields : [
        'patient_id',
        'patient_code',
        'no_ktp',
        'title',
        'name',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'blod',
        'education',
        'address',
        'rt',
        'rw',
        'country_id',
        'country_temp',
        'province_id',
        'province_temp',
        'district_id',
        'district_temp',
        'districts_id',
        'districts_temp',
        'kelurahan_id',
        'kelurahan_temp',
        'postal_code',
        'phone_number',
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_rs_patient/get',
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
