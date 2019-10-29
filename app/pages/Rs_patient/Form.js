Ext.define('App.pages.Rs_patient.Form',function(){
  var Variable = {};
  Variable.storeAppReligion    = Ext.create('App.store.App_religion');
  Variable.storeAreaCountry    = Ext.create('App.store.Area_country');
  Variable.storeAreaProvince   = Ext.create('App.store.Area_province');
  Variable.storeAreaDistrict   = Ext.create('App.store.Area_district');
  Variable.storeAreaDistricts  = Ext.create('App.store.Area_districts');
  Variable.storeAreaKelurahan  = Ext.create('App.store.Area_kelurahan');
  Variable.storeAppEducation   = Ext.create('App.store.App_education');
  Variable.storeAppJobdesk     = Ext.create('App.store.App_jobdesk');
  Variable.getStoreAppReligion = function(params, start, limit){
      Variable.storeAppReligion.load({
          params : {
              params  : params,
              start   : start,
              limit   : limit,
          }
      });
  };

  Variable.getStoreAppEducation = function(params, start, limit){
      Variable.storeAppEducation.load({
          params : {
              params  : params,
              start   : start,
              limit   : limit,
          }
      });
  };

  Variable.getStoreAreaCountry = function(params, start, limit){
      Variable.storeAreaCountry.load({
          params : {
              params  : params,
              start   : start,
              limit   : limit,
          }
      });
  };

  Variable.getStoreAreaProvince = function(params, start, limit){
      Variable.storeAreaProvince.load({
          params : {
              params  : params,
              start   : start,
              limit   : limit,
          }
      });
  };

  Variable.getStoreAreaDistrict = function(params, start, limit){
      Variable.storeAreaDistrict.load({
          params : {
              params  : params,
              start   : start,
              limit   : limit,
          }
      });
  };

  Variable.getStoreAreaDistricts = function(params, start, limit){
      Variable.storeAreaDistricts.load({
          params : {
              params  : params,
              start   : start,
              limit   : limit,
          }
      });
  };

  Variable.getStoreAreaKelurahan = function(params, start, limit){
      Variable.storeAreaKelurahan.load({
          params : {
              params  : params,
              start   : start,
              limit   : limit,
          }
      });
  };

  Variable.getStoreJobDesk = function(params, start, limit){
      Variable.storeAppJobdesk.load({
          params : {
              params  : params,
              start   : start,
              limit   : limit,
          }
      });
  };

    return{
      extend    : 'Ext.window.Window',
      autoShow  : true,
      frame     : true,
      title     : 'Form',
      width     : 600,
      modal     : true,
      constrain : true,
      plain     : true,
      items     : [
          {
              xtype: 'panel',
              dock: 'top',
              layout: {
                  type: 'hbox',
                  align: 'stretch'
              },
              items: [
                  {
                      xtype: 'form',
                      flex: 1,
                      bodyPadding: 10,
                      items: [
                          {
                              xtype   : 'textfield',
                              anchor  : '100%',
                              hidden  : true,
                          },{
                              xtype     : 'textfield',
                              anchor    : '100%',
                              fieldLabel: 'Medrec',
                              readOnly  : true,
                          },{
                              xtype           : 'combo',
                              store : new Ext.data.SimpleStore({
                                data : [
                                  [0, 'Tn'],
                                  [1, 'Ny'],
                                  [2, 'Sdr'],
                                ],
                                id : 0,
                                fields : ['value', 'text']
                              }),
                              forceSelection  : false,
                              valueField      : "text",
                              emptyText       : 'Select ...',
                              displayField    : "text",
                              fieldLabel      : "Title",
                              queryMode       : 'local',
                              anchor          : '100%',
                              listeners       : {
                                  change      : function(a, b){

                                  }
                              }
                          },{
                              xtype: 'textfield',
                              anchor: '100%',
                              fieldLabel: 'Nama Lengkap'
                          },
                          {
                              xtype: 'textfield',
                              anchor: '100%',
                              fieldLabel: 'Tempat lahir'
                          },
                          {
                              xtype: 'datefield',
                              anchor: '100%',
                              fieldLabel: 'Tanggal lahir',
                              format : 'Y-m-d',
                          },
                          {
                              xtype: 'radiogroup',
                              fieldLabel: 'Jenis Kelamin',
                              items: [
                                  {
                                      xtype   : 'radiofield',
                                      boxLabel: 'Laki-laki',
                                      name    : 'gender',
                                      checked : true,
                                      value   : 1
                                  },
                                  {
                                      xtype   : 'radiofield',
                                      boxLabel: 'Perempuan',
                                      name    : 'gender',
                                      value   : 0
                                  }
                              ]
                          },
                          {
                              xtype: 'textareafield',
                              anchor: '100%',
                              fieldLabel: 'Alamat'
                          },
                          {
                              xtype: 'textfield',
                              anchor: '100%',
                              fieldLabel: 'Telepon'
                          },
                          {
                              xtype: 'textfield',
                              anchor: '100%',
                              fieldLabel: 'Kode pos'
                          }
                      ]
                  },
                  {
                      xtype: 'form',
                      flex: 1,
                      bodyPadding: 10,
                      items: [
                          {
                              xtype           : 'combobox',
                              store           : Variable.storeAppReligion,
                              forceSelection  : false,
                              valueField      : "id",
                              emptyText       : 'Select ...',
                              displayField    : "religion",
                              queryMode       : 'local',
                              anchor          : '100%',
                              anchor          : '100%',
                              fieldLabel      : 'Agama',
                              listeners       : {
                                afterrender   : function(){
                                  Variable.getStoreAppReligion(" active_flag = '1' ", null, null);
                                }
                              }
                          },{
                              xtype           : 'combobox',
                              store           : Variable.storeAppEducation,
                              forceSelection  : false,
                              valueField      : "id",
                              emptyText       : 'Select ...',
                              displayField    : "education",
                              queryMode       : 'local',
                              anchor          : '100%',
                              anchor          : '100%',
                              fieldLabel      : 'Pendidikan',
                              listeners       : {
                                afterrender   : function(){
                                  Variable.getStoreAppEducation(" active_flag = '1' ", null, null);
                                }
                              }
                          },{
                              xtype           : 'combobox',
                              store           : Variable.storeAppJobdesk,
                              forceSelection  : false,
                              valueField      : "id",
                              emptyText       : 'Select ...',
                              displayField    : "jobdesk",
                              queryMode       : 'local',
                              anchor          : '100%',
                              anchor          : '100%',
                              fieldLabel      : 'Pekerjaan',
                              listeners       : {
                                afterrender   : function(){
                                  Variable.getStoreJobDesk(" active_flag = '1' ", null, null);
                                }
                              }
                          },{
                              xtype           : 'combobox',
                              store           : Variable.storeAreaCountry,
                              forceSelection  : false,
                              valueField      : "country_id",
                              emptyText       : 'Select ...',
                              displayField    : "country_name",
                              queryMode       : 'local',
                              anchor          : '100%',
                              anchor          : '100%',
                              fieldLabel      : 'Negara',
                              listeners       : {
                                afterrender   : function(){
                                  Variable.getStoreAreaCountry(" active_flag = '1' ", null, null);
                                },
                                select        : function(a, b){
                                  Variable.getStoreAreaProvince(" active_flag = '1' AND country_id = '"+b.data.country_id+"' ", null, null);
                                },
                                change        : function(a, b, c){
                                  Variable.getStoreAreaProvince(" active_flag = '1' AND country_id = '"+b+"' ", null, null);
                                }
                              }
                          },{
                              xtype           : 'combobox',
                              store           : Variable.storeAreaProvince,
                              forceSelection  : false,
                              valueField      : "province_id",
                              emptyText       : 'Select ...',
                              displayField    : "province",
                              queryMode       : 'local',
                              anchor          : '100%',
                              anchor          : '100%',
                              fieldLabel      : 'Propinsi',
                              listeners       : {
                                select        : function(a,b){
                                  Variable.getStoreAreaDistrict(" active_flag = '1' AND province_id = '"+b.data.province_id+"' ", null, null);
                                },
                                change        : function(a, b, c){
                                  Variable.getStoreAreaDistrict(" active_flag = '1' AND province_id = '"+b+"' ", null, null);
                                }
                              }
                          },{
                              xtype           : 'combobox',
                              store           : Variable.storeAreaDistrict,
                              forceSelection  : false,
                              valueField      : "district_id",
                              emptyText       : 'Select ...',
                              displayField    : "district",
                              queryMode       : 'local',
                              anchor          : '100%',
                              anchor          : '100%',
                              fieldLabel      : 'Kab/Kod',
                              listeners       : {
                                select        : function(a,b){
                                  Variable.getStoreAreaDistricts(" active_flag = '1' AND district_id = '"+b.data.district_id+"' ", null, null);
                                },
                                change        : function(a, b, c){
                                  Variable.getStoreAreaDistricts(" active_flag = '1' AND district_id = '"+b+"' ", null, null);
                                }
                              }
                          },{
                              xtype           : 'combobox',
                              store           : Variable.storeAreaDistricts,
                              forceSelection  : false,
                              valueField      : "districts_id",
                              emptyText       : 'Select ...',
                              displayField    : "districts",
                              queryMode       : 'local',
                              anchor          : '100%',
                              anchor          : '100%',
                              fieldLabel      : 'Kecamatan',
                              listeners       : {
                                select        : function(a,b){
                                  Variable.getStoreAreaKelurahan(" active_flag = '1' AND districts_id = '"+b.data.districts_id+"' ", null, null);
                                },
                                change        : function(a, b, c){
                                  Variable.getStoreAreaKelurahan(" active_flag = '1' AND districts_id = '"+b+"' ", null, null);
                                }
                              }
                          },{
                              xtype           : 'combobox',
                              store           : Variable.storeAreaKelurahan,
                              forceSelection  : false,
                              valueField      : "kelurahan_id",
                              emptyText       : 'Select ...',
                              displayField    : "kelurahan",
                              queryMode       : 'local',
                              anchor          : '100%',
                              anchor          : '100%',
                              fieldLabel      : 'Kelurahan',
                              listeners       : {
                              }
                          },
                      ]
                  }
              ]
          }
      ],
    	initComponent:function(){
    		this.callParent();
    	},
    }
});
