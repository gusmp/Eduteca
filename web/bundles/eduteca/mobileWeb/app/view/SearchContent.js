Ext.define("Eduteca.view.SearchContent", {
    extend: 'Ext.Container',
    alias: 'widget.searchContentPanel',

    initialize: function () 
    {
        this.callParent(arguments);
        
        var searchContainer = Ext.create('Ext.Container', 
            {
                title: 'Criterios de búsqueda',
                items: [
                    {
                        id: 'searchContentCourseId',
                        xtype: 'selectfield',
                        name : 'courseId',
                        label: 'Curso',
                        store: 'CourseCombo',
                        displayField: 'courseName',
                        valueField: 'courseId'
                    },
                    {
                        id: 'searchContentTitle',
                        xtype: 'textfield',
                        name : 'title',
                        label: 'Título'
                    },
                    {
                        id: 'searchContentDescription',
                        xtype: 'textfield',
                        name : 'description',
                        label: 'Descripción'
                    },
                    {
                        id: 'btSearchContent',
                        xtype: 'button',
                        text: 'Buscar'
                    }
                ]
            }
        );
            
        var resultContainer = Ext.create('Ext.Container', 
            {
                title: 'Resultados',
                layout: 'vbox',
                items: [
                    {
                        xtype: 'list',
                        id: 'listSearchContent',
                        flex: '1',
                        itemTpl: '<a href="getContent/{contentId}" target="_blank">{title}</a>',
                        store: 'Content',
                        scrollable: true,
                        listeners: 
                        {
                            select: function(view, record) 
                            {
                                //Ext.Msg.alert('Selected!', 'You selected ' + record.get('title'));
                            }
                        }
                    }
                ]
            }
        );
        
        var tabSearch = Ext.create('Ext.tab.Panel',
            {
                id: 'tabPanelSearchContent',
                xtype: 'tabpanel',
                items: [searchContainer, resultContainer]
            }
        );
        
        var topToolbar = {
            xtype: "toolbar",
            title: 'Buscar contenido',
            docked: "top"
        };

	this.add([topToolbar, tabSearch]);
        
    },
    
    config: {
        layout: {
            type: 'fit'
        }
    }
});
