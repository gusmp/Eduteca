Ext.define('Eduteca.view.user.EditUserForm',{
    extend   : 'Ext.window.Window',
    layout   : 'form',
    id       : 'exitUserForm',
    alias    : 'widget.exitUserForm',
    title    : 'Editar usuario',
    frame    : true,
    renderTo : Ext.getBody(),
    width    : 320,
    height   : 275,
    bodyStyle: 'padding:5px 5px 0',
    modal    : 'true',
    
    initComponent: function() 
    {
        var userId = Ext.getCmp('gridUser').getSelectionModel().getSelection()[0].data.userId;
        var user = Ext.getCmp('gridUser').store.getById(userId);
        
        this.items = [
            {
                xtype  : 'form',
                border : false,
                layout : 'form',
                bodyStyle:'background-color:#DFE8F6;',

                items: [
                    {
                        id: 'editUserUserId',
                        xtype: 'hidden',
                        name: 'userId',
                        value: user.get('userId')
                    },
                    {
                        id: 'editUserLogin',
                        xtype: 'textfield',
                        fieldLabel: 'Login',
                        name: 'login',
                        allowBlank:false,
                        minLength: 2,
                        value: user.get('login')
                    },
                    {
                        id: 'editUserPassword',
                        xtype: 'textfield',
                        fieldLabel: 'Contraseña',
                        name: 'password',
                        inputType: 'password',
                        allowBlank:false,
                        minLength: 2,
                        value: user.get('password')
                    },
                    {
                        id: 'editUserName',
                        xtype: 'textfield',
                        fieldLabel: 'Nombre',
                        name: 'name',
                        allowBlank:false,
                        minLength: 2,
                        value: user.get('name')
                    },
                    {
                        id: 'editUserSurname1',
                        xtype: 'textfield',
                        fieldLabel: 'Primer apellido',
                        name: 'surname1',
                        allowBlank:false,
                        minLength: 2,
                        value: user.get('surname1')
                    },
                    {
                        id: 'editUserSurname2',
                        xtype: 'textfield',
                        fieldLabel: 'Segundo apellido',
                        name: 'surname2',
                        allowBlank:true,
                        value: user.get('surname2')
                    },
                    {
                        id: 'editUserEmail',
                        xtype: 'textfield',
                        fieldLabel: 'Email',
                        name: 'email',
                        vtype:'email',
                        allowBlank:false,
                        value: user.get('email')
                    },
                    {
                        id: 'editUserApproved',
                        xtype: 'checkbox',
                        fieldLabel: 'Aprobado',
                        name: 'approved',
                        checked: user.get('approved')
                    },
                    {
                        id: 'editUserGroupId',
                        xtype: 'combo',
                        fieldLabel: 'Perfil',
                        name: 'groupId',
                        store: 'Group',
                        displayField:'groupName',
                        valueField:'groupId',
                        allowBlank:false,
                        value: user.getGroup().get('groupId')
                    }
                ]
            }
        ];
        
        this.buttons = [
            {
                id: 'btUserUpdate',
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


