Ext.define('Eduteca.view.course.NewCourseForm',{
    extend   : 'Ext.window.Window',
    layout   : 'form',
    id       : 'newCourseForm',
    alias    : 'widget.newCourseForm',
    title    : 'Nuevo curso',
    frame    : true,
    renderTo : Ext.getBody(),
    width    : 380,
    height   : 150,
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
                        xtype: 'textfield',
                        fieldLabel: 'Nombre del curso',
                        name: 'courseName',
                        allowBlank:false,
                        minLength: 2
                    }
                ]
            }
        ];
        
        this.buttons = [
            {
                id: 'btCourseSave',
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


