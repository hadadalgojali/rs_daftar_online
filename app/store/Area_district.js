Ext.define('App.store.Area_district', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    pageSize: 25,
    fields : [
        'district_id',
        'district',
        'province_id',
        'active_flag',
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_area_district/get',
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
