Ext.define('Eduteca.view.user.ListUserForm',{
    extend   : 'Ext.window.Window',
    layout   : 'form',
    id       : 'listUserForm',
    alias    : 'widget.listUserForm',
    title    : 'Lista de usuarios',
    frame    : true,
    renderTo : Ext.getBody(),
    bodyStyle:'padding:5px 5px 0',
    width    : 610,
    height   : 390,
    modal    : 'true',

    initComponent: function() 
    {
        this.items = 
        [
            {
                xtype: 'container',
                anchor: '100%',
                layout:'column',
                items:
                [
                    {
                        id: 'firstColumn',
                        xtype: 'container',
                        columnWidth:.5,
                        layout: 'anchor',
                        items: 
                        [
                            {
                                id: 'listUserLogin',
                                xtype:'textfield',
                                fieldLabel: 'Login',
                                name: 'login',
                                anchor:'96%'
                            },
                            {
                                id: 'listUserSurname1',
                                xtype:'textfield',
                                fieldLabel: 'Primer apellido',
                                name: 'surname1',
                                anchor:'96%'
                            },
                            {
                                id: 'listUserApproved',
                                xtype:'checkbox',
                                fieldLabel: 'Aprovado',
                                name: 'approved',
                                checked: false,
                                anchor:'96%'
                            }
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
                                id: 'listUserName',
                                xtype:'textfield',
                                fieldLabel: 'Nombre',
                                name: 'name',
                                anchor:'96%'
                            },
                            {
                                id: 'listUserSurname2',
                                xtype:'textfield',
                                fieldLabel: 'Segundo apellido',
                                name: 'surname2',
                                anchor:'96%'
                            },
                            {
                                id: 'listUserEmail',
                                xtype:'textfield',
                                fieldLabel: 'Email',
                                name: 'email',
                                anchor:'96%'
                            },
                            {
                                xtype: 'button',
                                text: 'Filtrar',
                                anchor:'96%',
                                handler: function()
                                {
                                    var valueLoginFilter = this.up('container').up('container').queryById('listUserLogin').value;
                                    var valueNameFilter = this.up('container').up('container').queryById('listUserName').value;
                                    var valueSurname1Filter = this.up('container').up('container').queryById('listUserSurname1').value;
                                    var valueSurname2Filter = this.up('container').up('container').queryById('listUserSurname2').value;
                                    var valueEmailFilter = this.up('container').up('container').queryById('listUserEmail').value;
                                    var valueApprovedFilter = this.up('container').up('container').queryById('listUserApproved').value;

                                    var store = this.up('window').down('grid').store;
                            
                                    Ext.getCmp('listUserForm').applyFilter(store, 'userLoginFilter', valueLoginFilter,'login');
                                    Ext.getCmp('listUserForm').applyFilter(store, 'userNameFilter', valueNameFilter,'name');
                                    Ext.getCmp('listUserForm').applyFilter(store, 'userSurname1Filter', valueSurname1Filter,'surname1');
                                    Ext.getCmp('listUserForm').applyFilter(store, 'userSurname2Filter', valueSurname2Filter,'surname2');
                                    Ext.getCmp('listUserForm').applyFilter(store, 'userEmailFilter', valueEmailFilter,'email');
                                    Ext.getCmp('listUserForm').applyFilter(store, 'userApprovedFilter', valueApprovedFilter,'approved');
                                    
                                    store.loadPage(1);
                                }
                            }
                        ]
                    }
                ]
            },
            {
                id: 'gridUser',
                xtype: 'grid',
                store: 'User',
                height: 200,
                selMode: new Ext.selection.RowModel({}),
                columns: [
                        { text: "id",   width: 0, dataIndex: 'userId',   sortable: true, resizable: false }, 
                        { text: "Login", width: 75, dataIndex: 'login', sortable: true, resizeable: true},
                        { text: "Nombre", width: 100, dataIndex: 'name', sortable: true, resizeable: true},
                        { text: "1 Apellido", width: 100, dataIndex: 'surname1', sortable: true, resizeable: true},
                        { text: "2 Apellido", width: 100, dataIndex: 'surname2', sortable: true, resizeable: true},
                        { text: "Aprovado", width: 55, dataIndex: 'approved', sortable: true, resizeable: true,
                                 renderer: function(approved)
                                 {
                                     if (approved == true) return 'Si';
                                     else return 'No';
                                 }
                        },
                        { text: "Email", width: 100, dataIndex: 'email', sortable: true, resizeable: true},
                        { 
                            xtype:'actioncolumn',
                            width: 25,
                            resizable: false,
                            menuDisabled: true,
                            items: [
                                {
                                    id: 'btUpdateUser',
                                    icon: '/eduteca/web/bundles/eduteca/admin/images/edit.png',
                                    tooltip: 'Editar',
                                    handler: function(grid, rowIndex, colIndex)  
                                    { 
                                        Ext.getCmp('listUserForm').actionUser(Ext.getCmp('listUserForm').editUserActionFn);
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
                                    id: 'gridDeleteUser',
                                    icon: '/eduteca/web/bundles/eduteca/admin/images/delete.png',
                                    tooltip: 'Borrar',
                                    handler: function(grid, rowIndex, colIndex)  
                                    { 
                                        Ext.getCmp('listUserForm').actionUser(Ext.getCmp('listUserForm').deleteUserActionFn);
                                    }
                                }
                            ]
                        }
                ],
                bbar: Ext.create('Ext.PagingToolbar', 
                    {
                        store: 'User',
                        displayInfo: true,
                        displayMsg: 'Mostrando los usuarios {0} - {1} de {2}',
                        emptyMsg: "No hay usuarios a mostrar"
                    }
                )
           }
        ];
        
        
        this.buttons = [
            {
                text: 'Editar',
                handler: function() 
                {
                    Ext.getCmp('listUserForm').actionUser(Ext.getCmp('listUserForm').editUserActionFn);
                }
            },
            {
                text: 'Borrar',
                handler: function() 
                {
                    Ext.getCmp('listUserForm').actionUser(Ext.getCmp('listUserForm').deleteUserActionFn);
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
        
        Ext.getCmp('gridUser').store.filters.removeAtKey('userLoginFilter');
        Ext.getCmp('gridUser').store.filters.removeAtKey('userNameFilter');
        Ext.getCmp('gridUser').store.filters.removeAtKey('userSurname1Filter');
        Ext.getCmp('gridUser').store.filters.removeAtKey('userSurname2Filter');
        Ext.getCmp('gridUser').store.filters.removeAtKey('userEmailFilter');
        Ext.getCmp('gridUser').store.filters.removeAtKey('userApprovedFilter');
       
        Ext.getCmp('gridUser').store.reload();
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
    
    actionUser: function(payloadFn)
    {
        if (Ext.getCmp('gridUser').getSelectionModel().getSelection().length < 1)
        {
            Ext.Msg.show(
            {
                title: 'Eduteca',
                msg: 'No hay ningún usuario seleccionado',
                buttons: Ext.MessageBox.YES,
                icon: Ext.MessageBox.INFO
            });
        }
        else
        {
            payloadFn();
        }
    },
    
    deleteUserActionFn: function()
    {
        Ext.Msg.show(
        {
            title: 'Eduteca',
            msg: '¿Realmente desea borrar el usuario?',
            buttons: Ext.MessageBox.YESNO,
            icon: Ext.MessageBox.WARNING,
            fn: function(btn) 
            {
                switch(btn)
                {
                    case 'yes':
                        var course = Ext.ModelManager.create(
                        Ext.getCmp('gridUser').getSelectionModel().getSelection()[0].data, 'Eduteca.model.User');
                            
                        course.destroy(
                        {
                            success: function(rec, op) { Ext.getCmp('gridUser').store.reload(); }
                        });
                    break;
                }
            }
        });
    },
    
    editUserActionFn: function()
    {
        new Eduteca.view.user.EditUserForm({}).show();
    }

});


