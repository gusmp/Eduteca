Ext.define('Eduteca.view.course.EditCourseForm',{
    extend   : 'Ext.window.Window',
    layout   : 'form',
    id       : 'editCourseForm',
    alias    : 'widget.editCourseForm',
    title    : 'Editar curso',
    frame    : true,
    renderTo : Ext.getBody(),
    width    : 500,
    height   : 250,
    bodyStyle: 'padding:5px 5px 0',
    modal    : 'true',
    
    initComponent: function() 
    {
        var courseId = Ext.getCmp('gridCourse').getSelectionModel().getSelection()[0].data.courseId;
        var course = Ext.getCmp('gridCourse').store.getById(courseId);
        
        this.items = [
            {
                xtype  : 'form',
                border : false,
                layout : 'form',
                bodyStyle:'background-color:#DFE8F6;',

                items: [
                    {
                        id: 'courseId',
                        xtype: 'hidden',
                        name: 'courseId',
                        value: course.get('courseId')
                    },
                    {
                        id: 'courseName',
                        xtype: 'textfield',
                        fieldLabel: 'Nombre del curso',
                        name: 'courseName',
                        allowBlank:false,
                        minLength: 2,
                        value: course.get('courseName')
                    },
                    {
                        xtype: 'grid',
                        title:'Contenidos vinculados al curso',
                        height: 150,
                        store: course.contents(),
                        selMode: new Ext.selection.RowModel({}),
                        columns: [
                             { text: "id",   width: 0, dataIndex: 'contentId',   sortable: true, resizable: false }, 
                             { text: "Título", width: 100, dataIndex: 'title', sortable: true, resizeable: true},
                             { text: "Descripción", width: 150, dataIndex: 'description', sortable: true, resizeable: true},
                             { text: "Archivo", width: 100, dataIndex: 'path', sortable: true, resizeable: true},
                             { text: "Publicado", width: 75, dataIndex: 'published', sortable: true, resizeable: true,
                                 renderer: function(published)
                                 {
                                     if (published == true) return 'Si';
                                     else return 'No';
                                 }
                             },
                             { 
                                 text: "Fecha", width: 125, dataIndex: 'date', sortable: true, resizeable: true,  
                                 renderer: function(date)
                                 {
                                     return Ext.util.Format.date(date,'d-m-Y H:i:s');
                                 }
                             }
                        ]
                    }
                ]
            }
        ];
        
        this.buttons = [
            {
                id: 'btCourseUpdate',
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


