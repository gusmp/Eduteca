Ext.define("Eduteca.view.Registration", {
    extend: 'Ext.Container',
    alias: 'widget.registrationPanel',

    initialize: function () 
    {
        this.callParent(arguments);
		
        var mainForm = Ext.create('Ext.form.Panel', 
        {
            //iconCls: 'user',
            layout: 'vbox',
            items: [
                {
                    xtype: 'fieldset',
                    title: '',
                    instructions: '',
                    defaults: { labelWidth: '35%' },
                    items: [
                        {
                            xtype: 'textfield',
                            name : 'login',
                            label: 'Login'
                        },
                        {
                            xtype: 'passwordfield',
                            name : 'password',
                            label: 'Password'
                        },
                                        {
                            xtype: 'textfield',
                            name : 'name',
                            label: 'Nombre'
                        },
                                        {
                            xtype: 'textfield',
                            name : 'surname1',
                            label: 'Primer apellido'
                        },
                        {
                            xtype: 'textfield',
                            name : 'surname2',
                            label: 'Segundo apellido'
                        },
                        {
                            xtype: 'emailfield',
                            name : 'email',
                            label: 'E-mail'
                        },
                        {
                            id: 'btNewUser',
                            xtype: 'button',
                            text: 'Registrarse',
                            style: 'margin: 0.1em'
                        }
                    ]
                }
            ]
        });

        var topToolbar = {
            xtype: "toolbar",
            title: 'Nuevo usuario',
            docked: "top"
        };

	this.add([topToolbar, mainForm]);

    },
    config: {
        layout: {
            type: 'fit'
        }
    }
});

