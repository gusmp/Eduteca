Ext.define('Eduteca.controller.Contents', {
    extend: 'Ext.app.Controller',
    stores: ['Content','CourseCombo'],
    models: ['Content'],
    views: ['TreeMenu', 'content.ListContentForm', 'content.NewContentForm', 'content.EditContentForm'],
    
    init: function()
    {
        this.control({
            
            '#treeMenu' : {
                itemclick: this.treeOptions
            },
            
            '#btContentSave': {
                click: this.btContentSave
            },
            
            '#btContentUpdate': {
                click: this.btContentUpdate
            }
        });
        
    },
    
    treeOptions: function(tree, record)
    {
        if (record.data.id == 'trOpContentNew')
        {
            new Eduteca.view.content.NewContentForm({}).show();
        }
        else if (record.data.id == 'trOpContentDel')
        {
            new Eduteca.view.content.ListContentForm({}).show();
        }
        else if (record.data.id == 'trOpContentMod')
        {
            new Eduteca.view.content.ListContentForm({}).show();
        }
    },
    
    btContentSave: function(bt)
    {
         this.userSaveUpdate(bt, false);
    },
    
    btContentUpdate: function(bt)
    {
        this.userSaveUpdate(bt, true);
    },
    
    userSaveUpdate: function(bt,isUpdate)
    {
        var form = bt.up('window').down('form').getForm();
        
        var waitMsg = '';
        var opMsg = '';
        if (isUpdate == false)
        {
            waitMsg = 'Guardando contenido...';
            opMsg = 'introducido';
        }
        else
        {
            waitMsg = 'Actualizando contenido...';
            opMsg = 'actualizado';
        }
        
        if (form.isValid() == true)
        {
            form.submit(
            {
                url: 'admin/contentUpdate',
                waitMsg: waitMsg,
                success: function(fp, o) 
                {
                    Ext.Msg.alert('Eduteca', 'El contenido "' + o.result.message + '" ha sido '+opMsg+' con éxito');
                    bt.up('window').close();
                    if (isUpdate == true)
                    {
                        Ext.getCmp('gridContent').store.reload();
                    }
                },
                failure: function(fp, o)
                {
                     Ext.Msg.show(
                    {
                        title: 'Eduteca',
                        msg: o.result.message,
                        buttons: Ext.MessageBox.YES,
                        icon: Ext.MessageBox.ERROR
                    });
                }
            });
        }
    }
    
});

