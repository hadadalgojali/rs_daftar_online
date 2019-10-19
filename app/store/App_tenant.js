Ext.define('App.store.App_tenant', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    fields : [
      'update_on',
      'update_by',
      'twitter_account_name',
      'twitter_account',
      'tenant_name',
      'tenant_id',
      'tenant_code',
      'tenant_address',
      'phone_number2',
      'phone_number1',
      'google_account_name',
      'google_account',
      'fax_number2',
      'fax_number1',
      'facebook_account_name',
      'facebook_account',
      'email',
      'create_on',
      'create_by',
      'country',
      'coordinate2',
      'coordinate1',
      'city',
      'active_flag',
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_app_tenant/get',
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
