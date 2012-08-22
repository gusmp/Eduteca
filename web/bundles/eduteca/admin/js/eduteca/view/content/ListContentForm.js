Ext.define('Eduteca.view.content.ListContentForm',{
    extend   : 'Ext.window.Window',
    layout   : 'form',
    id       : 'listContentForm',
    alias    : 'widget.listContentForm',
    title    : 'Lista de contenidos',
    frame    : true,
    renderTo : Ext.getBody(),
    bodyStyle:'padding:5px 5px 0',
    width    : 600,
    height   : 390,
    modal    : 'true',

    initComponent: function() 
    {
        
        this.items = [
        {
            xtype: 'container',
            anchor: '100%',
            layout:'column',
            items:[
            {
                id: 'firstColumn',
                xtype: 'container',
                columnWidth:.5,
                layout: 'anchor',
                items: 
                [
                    {
                        id: 'listContentTitle',
                        xtype:'textfield',
                        fieldLabel: 'Título',
                        name: 'title',
                        anchor:'96%'
                    },
                    {
                        id: 'listContentStartDate',
                        xtype:'datefield',
                        fieldLabel: 'Fecha inicio',
                        name: 'startDate',
                        anchor:'96%'
                    }, 
                    {
                        id: 'listContentCourseId',
                        xtype:'combo',
                        fieldLabel: 'Curso',
                        name: 'courseId',
                        store: 'CourseCombo',
                        displayField:'courseName',
                        valueField:'courseId',
                        anchor:'96%'
                        //queryMode : 'local'
                    }, 
                    {
                        id: 'listContentPublished',
                        xtype:'checkbox',
                        fieldLabel: 'Publicado',
                        name: 'published',
                        anchor:'96%'
                    }, 
                ]
            },
            {
                id: 'secondColumn',
                xtype: 'container',
                columnWidth:.5,
                layout: 'anchor',
                items: 
                [
                    {
                        id: 'listContentDescription',
                        xtype:'textfield',
                        fieldLabel: 'Descripción',
                        name: 'description',
                        anchor:'96%'
                    },
                    {
                        id: 'listContentEndDate',
                        xtype:'datefield',
                        fieldLabel: 'Fecha final',
                        name: 'endDate',
                        anchor:'96%'
                    },
                    {
                        id: 'listContentUserId',
                        xtype:'combo',
                        fieldLabel: 'Usuario',
                        name: 'userId',
                        store: 'UserCombo',
                        displayField:'login',
                        valueField:'userId',
                        anchor:'96%'
                        //queryMode : 'local'
                    },
                    {
                        xtype: 'button',
                        text: 'Filtrar',
                        anchor:'96%',
                        handler: function()
                        {
                            var valueTitleFilter = this.up('container').up('container').queryById('listContentTitle').value;
                            var valueDescriptionFilter = this.up('container').up('container').queryById('listContentDescription').value;
                            var valueStartDateFilter = this.up('container').up('container').queryById('listContentStartDate').value;
                            var valueEndDateFilter = this.up('container').up('container').queryById('listContentEndDate').value;
                            var valueCourseIdFilter = this.up('container').up('container').queryById('listContentCourseId').value;
                            var valueUserIdFilter = this.up('container').up('container').queryById('listContentUserId').value;
                            var valuePublishedFilter = this.up('container').up('container').queryById('listContentPublished').value;

                            var store = this.up('window').down('grid').store;
                            
                            Ext.getCmp('listContentForm').applyFilter(store, 'contentTitleFilter', valueTitleFilter,'title');
                            Ext.getCmp('listContentForm').applyFilter(store, 'contentDescriptionFilter', valueDescriptionFilter,'description');
                            Ext.getCmp('listContentForm').applyFilter(store, 'contentStartDateFilter', valueStartDateFilter,'startDate');
                            Ext.getCmp('listContentForm').applyFilter(store, 'contentEndDateFilter', valueEndDateFilter,'endDate');
                            Ext.getCmp('listContentForm').applyFilter(store, 'contentCourseIdFilter', valueCourseIdFilter,'courseId');
                            Ext.getCmp('listContentForm').applyFilter(store, 'contentUserIdFilter', valueUserIdFilter,'userId');
                            Ext.getCmp('listContentForm').applyFilter(store, 'contentPublishedFilter', valuePublishedFilter,'published');
                            
                            store.loadPage(1);
                        }
                    }
                ]
            }]
        },
        {
                id: 'gridContent',
                xtype: 'grid',
                store: 'Content',
                height: 200,
                
                selMode: new Ext.selection.RowModel({}),
                columns: [
                        { text: "id",   width: 0, dataIndex: 'contentId',   sortable: true, resizable: false }, 
                        { text: "Título", width: 100, dataIndex: 'title', sortable: true, resizeable: true},
                        { text: "Descripcion", width: 150, dataIndex: 'description', sortable: true, resizeable: true},
                        { text: "Archivo", width: 100, dataIndex: 'path', sortable: true, resizeable: true},
                        { text: "Publicado", width: 55, dataIndex: 'published', sortable: true, resizeable: true,
                                 renderer: function(published)
                                 {
                                     if (published == true) return 'Si';
                                     else return 'No';
                                 }
                        },
                        { 
                          text: "Fecha", width: 90, dataIndex: 'date', sortable: true, resizeable: true,  
                                renderer: function(date)
                                {
                                     return Ext.util.Format.date(date,'d-m-Y H:i:s');
                                }
                        },
                        { 
                            xtype:'actioncolumn',
                            width: 25,
                            resizable: false,
                            menuDisabled: true,
                            items: [
                                {
                                    icon: '/eduteca/web/bundles/eduteca/admin/images/edit.png',
                                    tooltip: 'Editar',
                                    handler: function(grid, rowIndex, colIndex)  
                                    { 
                                        Ext.getCmp('listContentForm').actionContent(Ext.getCmp('listContentForm').editContentActionFn);
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
                                    icon: '/eduteca/web/bundles/eduteca/admin/images/delete.png',
                                    tooltip: 'Borrar',
                                    handler: function(grid, rowIndex, colIndex)  
                                    { 
                                        Ext.getCmp('listContentForm').actionContent(Ext.getCmp('listContentForm').deleteContentActionFn);
                                    }
                                }
                            ]
                        },
                        {
                            xtype:'actioncolumn',
                            width: 25,
                            resizable: false,
                            menuDisabled: true,
                            dataIndex: 'contentId',
                            renderer: function(courseId) 
                            {
                                return '<a href="admin/contentDownload/'+courseId+'" target="_blank"><img src="/eduteca/web/bundles/eduteca/admin/images/view.png" title="Descargar"/></a>';
                            }
                        }
                ],
                bbar: Ext.create('Ext.PagingToolbar', 
                    {
                        store: 'Content',
                        displayInfo: true,
                        displayMsg: 'Mostrando los contenidos {0} - {1} de {2}',
                        emptyMsg: "No hay contenidos a mostrar"
                    }
                )
           }
        ];
        
        this.buttons = [
            {
                text: 'Editar',
                handler: function() 
                {
                    Ext.getCmp('listContentForm').actionContent(Ext.getCmp('listContentForm').editContentActionFn);
                }
            },
            {
                text: 'Borrar',
                handler: function() 
                {
                    Ext.getCmp('listContentForm').actionContent(Ext.getCmp('listContentForm').deleteContentActionFn);
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
        // Should by Ext.getCmp('gridContent').store.clearFilter(true); but it does not work
        Ext.getCmp('gridContent').store.filters.removeAtKey('contentTitleFilter');
        Ext.getCmp('gridContent').store.filters.removeAtKey('contentDescriptionFilter');
        Ext.getCmp('gridContent').store.filters.removeAtKey('contentStartDateFilter');
        Ext.getCmp('gridContent').store.filters.removeAtKey('contentEndDateFilter');
        Ext.getCmp('gridContent').store.filters.removeAtKey('contentCourseIdFilter');
        Ext.getCmp('gridContent').store.filters.removeAtKey('contentUserIdFilter');
        Ext.getCmp('gridContent').store.filters.removeAtKey('contentPublishedFilter');
        
        Ext.getCmp('gridContent').store.reload();
    },
    
    applyFilter: function(store, filterName, valueProperty, propertyName)
    {
        if ((valueProperty != null) && (valueProperty != ''))
        {
            store.filters.add(filterName, 
                new Ext.util.Filter( { property: propertyName, value: valueProperty, filterFn: function(item) { return true; }}));
        }
        else
        {
            store.filters.removeAtKey(filterName);
        }
    },
    
    actionContent: function(payloadFn)
    {
        if (Ext.getCmp('gridContent').getSelectionModel().getSelection().length < 1)
        {
            Ext.Msg.show(
            {
                title: 'Eduteca',
                msg: 'No hay ningún contenido seleccionado',
                buttons: Ext.MessageBox.YES,
                icon: Ext.MessageBox.INFO
            });
        }
        else
        {
            payloadFn();
        }
    },
    
    deleteContentActionFn: function()
    {
        Ext.Msg.show(
        {
            title: 'Eduteca',
            msg: '¿Realmente desea borrar el contenido?',
            buttons: Ext.MessageBox.YESNO,
            icon: Ext.MessageBox.WARNING,
            fn: function(btn) 
            {
                switch(btn)
                {
                    case 'yes':
                        var content = Ext.ModelManager.create(
                        Ext.getCmp('gridContent').getSelectionModel().getSelection()[0].data, 'Eduteca.model.Content');
                        
                        content.destroy(
                        {
                            success: function(rec, op) { Ext.getCmp('gridContent').store.reload(); }
                        });

                    break;
                }
            }
        });
    },
    
    editContentActionFn: function()
    {
        new Eduteca.view.content.EditContentForm({}).show();
    }

});


