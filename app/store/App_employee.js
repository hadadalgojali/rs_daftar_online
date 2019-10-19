Ext.define('App.store.App_employee', {
    autoLoad: false,
    extend: 'Ext.data.Store',
    fields : [
        'employee_id',
        'id_number',
        'first_name',
        'last_name',
        'gender',
        'religion',
        'birth_place',
        'birth_date',
        'address',
        'email_address',
        'phone_number1',
        'phone_number2',
        'fax_number1',
        'job_id',
        'job_name',
        'active_flag',
        'user_code',
        'role_id',
        'role_name',
        'active_flag_user',
    ],
    proxy: {
        type: 'ajax',
        url: url+'app/C_app_employee/get',
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
