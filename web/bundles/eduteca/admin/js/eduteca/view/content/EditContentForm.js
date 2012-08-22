Ext.define('Eduteca.view.content.EditContentForm',{
    extend   : 'Ext.window.Window',
    layout   : 'form',
    id       : 'editContentForm',
    alias    : 'widget.editContentForm',
    title    : 'Editar contenido',
    frame    : true,
    renderTo : Ext.getBody(),
    width    : 400,
    height   : 300,
    bodyStyle: 'padding:5px 5px 0',
    modal    : 'true',
    
    initComponent: function() 
    {
        var contentId = Ext.getCmp('gridContent').getSelectionModel().getSelection()[0].data.contentId;
        var content = Ext.getCmp('gridContent').store.getById(contentId);
        
        this.items = [
            {
                xtype  : 'form',
                border : false,
                layout : 'form',
                bodyStyle:'background-color:#DFE8F6;',

                items: [
                    {
                        id: 'editContentContentId',
                        xtype: 'hidden',
                        name: 'contentId',
                        value: content.get('contentId')
                    },
                    {
                        id: 'editContentCourseId',
                        xtype: 'combo',
                        fieldLabel: 'Curso',
                        name: 'courseId',
                        store: 'CourseCombo',
                        displayField:'courseName',
                        valueField:'courseId',
                        allowBlank:false,
                        value: content.getCourse().get('courseId'),
                        listeners: 
                        {
                            afterrender: function(combo) { }
                        }
                    },
                    {
                        id: 'editContentTitle',
                        xtype: 'textfield',
                        fieldLabel: 'Título',
                        name: 'title',
                        allowBlank:false,
                        minLength: 2,
                        value: content.get('title')
                    },
                    {
                        id: 'editContentDescription',
                        xtype: 'textarea',
                        fieldLabel: 'Descripción',
                        name: 'description',
                        allowBlank:false,
                        minLength: 2,
                        value: content.get('description')
                    },
                    {
                        id: 'editContentPath',
                        xtype: 'fileuploadfield',
                        fieldLabel: 'Archivo',
                        name: 'path',
                        //allowBlank:false,
                        emptyText: content.get('path'),
                        buttonText: '',
                        buttonConfig: {
                            iconCls: 'upload-icon'
                        }
                    },
                    {
                        id: 'editContentPublished',
                        xtype: 'checkbox',
                        fieldLabel: 'Publicado',
                        name: 'published',
                        checked: content.get('published')
                    },
                    {
                        id: 'editContentDate',
                        xtype: 'textfield',
                        fieldLabel: 'Fecha',
                        name: 'date',
                        value: Ext.util.Format.date(content.get('date'),'d-m-Y H:i:s'),
                        readOnly: true
                    },
                    {
                        id: 'editContentUserId',
                        xtype: 'combo',
                        fieldLabel: 'Usuario',
                        name: 'userId',
                        store: 'UserCombo',
                        displayField:'login',
                        valueField:'userId',
                        allowBlank:false,
                        value: content.getUser().get('userId'),
                        listeners: 
                        {
                            afterrender: function(combo) { }
                        }
                    }
                ]
            }
        ];
        
        this.buttons = [
            {
                id: 'btContentUpdate',
                text: 'Editar'
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


