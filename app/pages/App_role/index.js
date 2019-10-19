var pageCustomer = {};
pageCustomer.storeobj=Ext.create('Neptune.store.Customer');
pageCustomer.getStore = function(params, start, limit){
    pageCustomer.storeobj.load({
        params : {
            params      : params,
            start       : start,
            limit       : limit,
        }
    });
}

pageCustomer.create  = false;
pageCustomer.update  = false;
pageCustomer.delete  = false;
pageCustomer.print   = false;

if (common.trustee().Customer.create == 0) {
  pageCustomer.create = true;
}

if (common.trustee().Customer.update == 0) {
  pageCustomer.update = true;
}

if (common.trustee().Customer.delete == 0) {
  pageCustomer.delete = true;
}

if (common.trustee().Customer.print == 0) {
  pageCustomer.print = true;
}

Ext.define('Neptune.view.page.customer.index', {
    extend: 'Ext.panel.Panel',
    xtype: 'Customer',
    id: 'page-customer',
    defaults: {
        height: '100%',
        width: '100%',
    },
    layout  : 'fit',
    title: 'Data Customer',
    tools: [
        {
            type     : 'plus',
            disabled : pageCustomer.create,
            handler  : function(){
                Ext.create('Neptune.view.page.customer.form', {
                    fbar    : [
                        {
                            xtype   : 'button',
                            text    : 'Save',
                            handler : function(btn){
                                var win = btn.up('window'), form = win.down('form');
                                Ext.Ajax.request({
                                    method: 'post',
                                    url: base_url+"index.php/C_customer/save",
                                    waitTitle: 'Connecting',
                                    waitMsg: 'Sending data...',
                                    params: {
                                        'id'        : win.items.items[0].lastValue,
                                        'first_name': win.items.items[1].lastValue,
                                        'last_name' : win.items.items[2].lastValue,
                                        'address'   : win.items.items[3].lastValue,
                                        'phone'     : win.items.items[4].lastValue,
                                        'email'     : win.items.items[5].lastValue,
                                    },
                                    // scope:this,
                                    success: function(res){
                                        var cst = JSON.parse(res.responseText);
                                        Ext.Msg.alert("Create", ""+cst.message+"");
                                        pageCustomer.getStore(null, 0, 25);
                                    },
                                    failure: function(){
                                        console.log('failure');
                                    }
                                });
                            }
                        },{
                            xtype   : 'button',
                            text    : 'Close',
                            handler : function(btn){
                                var win = btn.up('window');
                                win.close();
                            }
                        },
                    ],
                }).show();
            }
        },
        {
            type     : 'minus',
            disabled : pageCustomer.delete,
            handler  : function(){
                pageCustomer.id = [];
                selected = pageCustomer.grid.getView().getSelectionModel().getSelection();
                    Ext.each(selected, function (item) {
                    pageCustomer.id.push(item.data.id);
                });
                Ext.MessageBox.confirm('Delete', 'Are you sure ?', function(btn){
                    if(btn === 'yes'){
                        Ext.Ajax.request({
                            method      : 'post',
                            url         : base_url+"index.php/C_customer/delete",
                            waitTitle   : 'Connecting',
                            waitMsg     : 'Sending data...',
                            params      : {
                                id      : JSON.stringify(pageCustomer.id),
                            },
                            // scope:this,
                            success: function(res){
                                pageCustomer.getStore(null, 0, 25);
                            },
                            failure: function(){
                                console.log('failure');
                            }
                        });
                    }
                });
            }
        },{
            type: 'search',
            handler : function(){
                Ext.create('Neptune.view.page.customer.search',{
                    title   : "Search Customer",
                    fbar    : [
                        {
                            xtype   : 'button',
                            text    : 'Search',
                            handler : function(btn){
                                var win = btn.up('window'), form = win.down('form');
                                var params = "";

                                if (win.items.items[0].lastValue!= undefined) {
                                    if (win.items.items[0].lastValue!= "") {
                                        if (params != "") {
                                            params += " AND ";
                                        }
                                        params += "lower(first_name) like lower('%"+win.items.items[0].lastValue+"%') OR lower(last_name) like lower('%"+win.items.items[0].lastValue+"%')";
                                    }
                                }
                                if (win.items.items[1].lastValue!= undefined) {
                                    if (win.items.items[1].lastValue!= "") {
                                        if (params != "") {
                                            params += " AND ";
                                        }
                                        params += "lower(address) like lower('%"+win.items.items[1].lastValue+"%')";
                                    }
                                }
                                pageCustomer.getStore(params, 0, 25);
                            }
                        },{
                            xtype   : 'button',
                            text    : 'Close',
                            handler : function(btn){
                                var win = btn.up('window');
                                win.close();
                            }
                        }
                    ],
                }).show();
            }
        },{
            type    : 'print',
            disabled: pageCustomer.print,
            handler : function(){
                var url     = base_url+"index.php/C_customer/report/";
                Ext.create('Neptune.view.general.print',{
                    tbar    : [
                        {
                            xtype   : 'button',
                            text    : 'PDF',
                        },{
                            xtype   : 'button',
                            text    : 'Excel',
                        },{
                            xtype   : 'button',
                            text    : 'Direct',
                        },
                    ],
                    fbar    : [
                        {
                            xtype   : 'button',
                            text    : 'Close',
                            handler : function(btn){
                                var win = btn.up('window');
                                win.close();
                            }
                        }
                    ],
                    width   : 800,
                    height  : 650,
                    html    : "<iframe  style='width: 100%; height: 100%;' src='" + url + "/true" + "'></iframe>"
                }).show();
            }
        },
        { type: 'help' },
    ],
    autoScroll  : true,
    items : [
        pageCustomer.grid = Ext.create('Ext.grid.Panel', {
            store: pageCustomer.storeobj,
            selModel: Ext.create('Ext.selection.CheckboxModel'),
            columns: [
                { header: 'First Name',  dataIndex: 'first_name',  editor : 'textfield'},
                { header: 'Last Name',  dataIndex: 'last_name', width:250,  editor : 'textfield'},
                { header: 'Address', dataIndex: 'address', flex: 1, editor : 'textfield'},
                { header: 'Phone', dataIndex: 'phone', width:250,  editor : 'textfield'},
                { header: 'Email', dataIndex: 'email', width:250,  editor : 'textfield'},
            ],
            anchor  : '100% 100%',
            width   : '100%',
            height  : '100%',
            dockedItems: [{
                xtype: 'pagingtoolbar',
                store: pageCustomer.storeobj,
                pageSize: 10,
                dock: 'bottom',
                displayInfo: true
            }],
            viewConfig: {
                listeners: {
                    itemdblclick: function(dataview, index, item, e) {
                        Ext.create('Neptune.view.page.customer.form', {
                            id      : 'formOutlet',
                            fbar    : [
                                {
                                    xtype   : 'button',
                                    text    : 'Update',
                                    disabled: pageCustomer.update,
                                    handler : function(btn){
                                        var win = btn.up('window'), form = win.down('form');
                                        Ext.Ajax.request({
                                            method: 'post',
                                            url: base_url+"index.php/C_customer/update",
                                            waitTitle: 'Connecting',
                                            waitMsg: 'Sending data...',
                                            params: {
                                                'id'        : win.items.items[0].lastValue,
                                                'first_name': win.items.items[1].lastValue,
                                                'last_name' : win.items.items[2].lastValue,
                                                'address'   : win.items.items[3].lastValue,
                                                'phone'     : win.items.items[4].lastValue,
                                                'email'     : win.items.items[5].lastValue,
                                            },
                                            success: function(res){
                                                var cst = JSON.parse(res.responseText);
                                                Ext.Msg.alert("Update", ""+cst.message+"");
                                                pageCustomer.getStore(null, 0, 25);
                                            },
                                            failure: function(){
                                                console.log('failure');
                                            }
                                        });
                                    }
                                },{
                                    xtype   : 'button',
                                    text    : 'Close',
                                    handler : function(btn){
                                        var win = btn.up('window');
                                        win.close();
                                    }
                                },
                            ],
                            listeners: {
                                show: function(thisForm){
                                    // console.log(thisHeader);
                                    thisForm.items.items[0].setValue(index.data.id);
                                    thisForm.items.items[1].setValue(index.data.first_name);
                                    thisForm.items.items[2].setValue(index.data.last_name);
                                    thisForm.items.items[3].setValue(index.data.address);
                                    thisForm.items.items[4].setValue(index.data.phone);
                                    thisForm.items.items[5].setValue(index.data.email);
                                },
                            }
                        }).show();
                    }
                }
            },
            // renderTo: Ext.getBody()
        }),
    ],
    // renderTo: Ext.getBody(),
    listeners: {
        show: function(thisHeader){
            // pageOutlet.form = Ext.create('Neptune.view.page.outlet.form');
            pageCustomer.getStore(null, 0, 25);
        },
    }
    // html: NeptuneAppData.dummyText
});
