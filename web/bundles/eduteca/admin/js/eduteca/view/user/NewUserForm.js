Ext.define('Eduteca.view.user.NewUserForm',{
    extend   : 'Ext.window.Window',
    layout   : 'form',
    id       : 'newUserForm',
    alias    : 'widget.newUserForm',
    title    : 'Nuevo usuario',
    frame    : true,
    renderTo : Ext.getBody(),
    width    : 320,
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
                        xtype: 'textfield',
                        fieldLabel: 'Login',
                        name: 'login',
                        allowBlank:false,
                        minLength: 2
                    },
                    {
                        xtype: 'textfield',
                        fieldLabel: 'Contraseña',
                        name: 'password',
                        inputType: 'password',
                        allowBlank:false,
                        minLength: 2
                    },
                    {
                        xtype: 'textfield',
                        fieldLabel: 'Nombre',
                        name: 'name',
                        allowBlank:false,
                        minLength: 2
                    },
                    {
                        xtype: 'textfield',
                        fieldLabel: 'Primer apellido',
                        name: 'surname1',
                        allowBlank:false,
                        minLength: 2
                    },
                    {
                        xtype: 'textfield',
                        fieldLabel: 'Segundo apellido',
                        name: 'surname2',
                        allowBlank:true
                    },
                    {
                        xtype: 'textfield',
                        fieldLabel: 'Email',
                        name: 'email',
                        vtype:'email',
                        allowBlank:false
                    },
                    {
                        xtype: 'checkbox',
                        fieldLabel: 'Aprobado',
                        name: 'approved',
                        checked: true
                    },
                    {
                        xtype: 'combo',
                        fieldLabel: 'Perfil',
                        name: 'groupId',
                        store: 'Group',
                        displayField:'groupName',
                        valueField:'groupId',
                        allowBlank:false
                    }
                ]
            }
        ];
        
        this.buttons = [
            {
                id: 'btUserSave',
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


