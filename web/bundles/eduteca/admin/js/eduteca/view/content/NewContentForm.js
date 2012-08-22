Ext.define('Eduteca.view.content.NewContentForm',{
    extend   : 'Ext.window.Window',
    layout   : 'form',
    id       : 'newContentForm',
    alias    : 'widget.newContentForm',
    title    : 'Nuevo contenido',
    frame    : true,
    renderTo : Ext.getBody(),
    width    : 380,
    height   : 275,
    bodyStyle: 'padding:5px 5px 0',
    modal    : 'true',
    
    initComponent: function() 
    {
        
        this.items = [
            {
                xtype  : 'form',
                border : false,
                layout : 'form',
                bodyStyle:'background-color:#DFE8F6;',

                items: [
                    {
                        xtype: 'combo',
                        fieldLabel: 'Curso',
                        name: 'courseId',
                        store: 'CourseCombo',
                        displayField:'courseName',
                        valueField:'courseId',
                        allowBlank:false,
                        listeners: 
                        {
                            afterrender: function(combo) { }
                        }
                    },
                    {
                        xtype: 'textfield',
                        fieldLabel: 'Titulo',
                        name: 'title',
                        allowBlank:false,
                        minLength: 2
                        
                    },
                    {
                        xtype: 'textarea',
                        fieldLabel: 'Descripción',
                        name: 'description',
                        allowBlank:false,
                        minLength: 2
                    },
                    {
                        xtype: 'fileuploadfield',
                        fieldLabel: 'Archivo',
                        name: 'path',
                        allowBlank:false,
                        emptyText: 'Seleccionar un documento',
                        buttonText: '',
                        buttonConfig: {
                            iconCls: 'upload-icon'
                        }
                    },
                    {
                        xtype: 'checkbox',
                        fieldLabel: 'Publicado',
                        name: 'published'
                    }
                ]
            }
        ];
        
        this.buttons = [
            {
                id: 'btContentSave',
                text: 'Guardar'
            },
            {
                text: 'Cancelar',
                handler: function() 
                {
                    this.up('window').close();
                }
            }
        ];
        
        this.callParent(arguments);
    }
    
});


