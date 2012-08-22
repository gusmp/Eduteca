Ext.define('Eduteca.view.course.ListCourseForm',{
    extend   : 'Ext.window.Window',
    layout   : 'form',
    id       : 'listCourseForm',
    alias    : 'widget.listCourseForm',
    title    : 'Lista de cursos',
    frame    : true,
    renderTo : Ext.getBody(),
    bodyStyle:'padding:5px 5px 0',
    width    : 490,
    height   : 310,
    modal    : 'true',

    initComponent: function() 
    {
        this.items = [
           {
               xtype: 'panel',
               layout: 'hbox',
               margin: '2 0 10 0',
               bodyStyle:'background-color:#DFE8F6;',
               border: false,
               
               items: [
                   {
                        xtype: 'textfield',
                        fieldLabel: 'Nombre del curso',
                        name: 'courseName'
                   },
                   {
                        xtype: 'button',
                        text: 'Filtrar',
                        handler: function()
                        {
                            var value2Filter = this.up('window').down('textfield').value;
                            var store = this.up('window').down('grid').store;
                            if (value2Filter != '')
                            {
                               store.filters.add('courseNameFilter', 
                                    new Ext.util.Filter({
                                        property: 'courseName',
                                        value: value2Filter,
                                        filterFn: function(item) { return true; }
                                    })
                                );
                            }
                            else
                            {
                                store.filters.removeAtKey('courseNameFilter');
                            }

                            store.loadPage(1);
                        }
                    }
               ]
           },
           {
                id: 'gridCourse',
                xtype: 'grid',
                store: 'Course',
                height: 200,
                selMode: new Ext.selection.RowModel({}),
                columns: [
                        { text: "id",   width: 0, dataIndex: 'courseId',   sortable: true, resizable: false }, 
                        { text: "Título del curso", width: 400, dataIndex: 'courseName', sortable: true, resizeable: true},
                        { 
                            xtype:'actioncolumn',
                            width: 25,
                            resizable: false,
                            menuDisabled: true,
                            items: [
                                {
                                    id: 'btEditCourse',
                                    icon: '/eduteca/web/bundles/eduteca/admin/images/edit.png',
                                    tooltip: 'Editar',
                                    handler: function(grid, rowIndex, colIndex)  
                                    { 
                                        Ext.getCmp('listCourseForm').actionCourse(Ext.getCmp('listCourseForm').editCourseActionFn);
                                    }
                                }
                            ]
                        },
                        {
                            xtype:'actioncolumn',
                            width: 25,
                            resizable: false,
                            menuDisabled: true,
                            items: [
                                {
                                    id: 'gridDeleteCourse',
                                    icon: '/eduteca/web/bundles/eduteca/admin/images/delete.png',
                                    tooltip: 'Borrar',
                                    handler: function(grid, rowIndex, colIndex)  
                                    { 
                                        Ext.getCmp('listCourseForm').actionCourse(Ext.getCmp('listCourseForm').deleteCourseActionFn);
                                    }
                                }
                            ]
                        }
                ],
                bbar: Ext.create('Ext.PagingToolbar', 
                    {
                        store: 'Course',
                        displayInfo: true,
                        displayMsg: 'Mostrando los cursos {0} - {1} de {2}',
                        emptyMsg: "No hay cursos a mostrar"
                    }
                )
           }
        ];
        
        
        this.buttons = [
            {
                text: 'Editar',
                handler: function() 
                {
                    Ext.getCmp('listCourseForm').actionCourse(Ext.getCmp('listCourseForm').editCourseActionFn);
                }
            },
            {
                text: 'Borrar',
                handler: function() 
                {
                    Ext.getCmp('listCourseForm').actionCourse(Ext.getCmp('listCourseForm').deleteCourseActionFn);
                }
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
        Ext.getCmp('gridCourse').store.filters.removeAtKey('courseNameFilter');
        Ext.getCmp('gridCourse').store.reload();
    },
    
    actionCourse: function(payloadFn)
    {
        if (Ext.getCmp('gridCourse').getSelectionModel().getSelection().length < 1)
        {
            Ext.Msg.show(
            {
                title: 'Eduteca',
                msg: 'No hay ningún curso seleccionado',
                buttons: Ext.MessageBox.YES,
                icon: Ext.MessageBox.INFO
            });
        }
        else
        {
            payloadFn();
        }
    },
    
    deleteCourseActionFn: function()
    {
        Ext.Msg.show(
        {
            title: 'Eduteca',
            msg: '¿Realmente desea borrar el curso?',
            buttons: Ext.MessageBox.YESNO,
            icon: Ext.MessageBox.WARNING,
            fn: function(btn) 
            {
                switch(btn)
                {
                    case 'yes':
                        var course = Ext.ModelManager.create(
                        Ext.getCmp('gridCourse').getSelectionModel().getSelection()[0].data, 'Eduteca.model.Course');
                            
                        course.destroy(
                        {
                            success: function(rec, op) { Ext.getCmp('gridCourse').store.reload(); }
                        });
                    break;
                }
            }
        });
    },
    
    editCourseActionFn: function()
    {
        new Eduteca.view.course.EditCourseForm({}).show();
    }

});


