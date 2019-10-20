Ext.define('App.pages.Rs_penyakit.Form',function(){
    return{
      extend : 'Ext.window.Window',
      title: 'Form',
      closable: true,
      width: 500,
      modal:true,
      constrain: true,
      plain: true,
      layout: 'form',
      bodyStyle: 'padding: 5px;',
      items: [
          {
              xtype       : 'textfield',
              fieldLabel  : 'Kode Penyakit',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Parent',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Penyakit',
          },{
              xtype       : 'textarea',
              fieldLabel  : 'Deskripsi',
          },{
              xtype       : 'textarea',
              fieldLabel  : 'Note',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Include',
          },{
              xtype       : 'textfield',
              fieldLabel  : 'Exlude',
          },{
              xtype: 'checkboxfield',
              anchor: '100%',
              fieldLabel: 'Status',
              boxLabel: ''
          },{
              xtype: 'checkboxfield',
              anchor: '100%',
              fieldLabel: 'Non Rujukan',
              boxLabel: ''
          }
      ],
    	initComponent:function(){
    		this.callParent();
    	},
    }
});
