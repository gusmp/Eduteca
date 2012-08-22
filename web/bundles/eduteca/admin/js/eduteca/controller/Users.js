Ext.define('Eduteca.controller.Users', {
    extend: 'Ext.app.Controller',
    stores: ['User','UserCombo','Group'],
    models: ['User'],
    views: ['TreeMenu', 'user.ListUserForm', 'user.NewUserForm', 'user.EditUserForm'],
    
    init: function()
    {
        
        this.control({
            
            '#treeMenu' : {
                itemclick: this.treeOptions
            },
            
            '#btUserSave': {
                click: this.btUserSave
            },
            
            '#btUserUpdate': {
                click: this.btUserUpdate
            }
        });
    },
    
    treeOptions: function(tree, record)
    {
        if (record.data.id == 'trOpUserNew')
        {
            new Eduteca.view.user.NewUserForm({}).show();
        }
        else if (record.data.id == 'trOpUserDel')
        {
            new Eduteca.view.user.ListUserForm({}).show();
        }
        else if (record.data.id == 'trOpUserMod')
        {
            new Eduteca.view.user.ListUserForm({}).show();
        }
    },
    
    btUserSave: function(bt)
    {
       this.userSaveUpdate(bt, false);
    },

    btUserUpdate: function(bt)
    {
        this.userSaveUpdate(bt, true);
    },
    
    userSaveUpdate: function(bt,refeshData)
    {
        var form = bt.up('window').down('form').getForm();
        
        var user = Ext.create('Eduteca.model.User', form.getValues());
        if (form.getValues().approved != null) 
        {
            user.data.approved = true;
        }
            
        var errors = user.validate();
        
        if (errors.isValid() == true)
        {
            user.save(
            {
                success: function(rec, op) 
                {
                    bt.up('window').close();
                    if (refeshData == true)
                    {
                        Ext.getCmp('gridUser').store.reload();
                    }
                },
                failure: function(rec, op) 
                {
                    Ext.Msg.show(
                    {
                        title: 'Eduteca',
                        msg: op.request.scope.reader.jsonData["message"],
                        buttons: Ext.MessageBox.YES,
                        icon: Ext.MessageBox.ERROR
                    }); 
                }
            });
        }
    }
 

});

