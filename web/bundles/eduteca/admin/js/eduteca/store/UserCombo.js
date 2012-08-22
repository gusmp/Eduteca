Ext.define('Eduteca.store.UserCombo', {
    extend: 'Ext.data.Store',
    model: 'Eduteca.model.User',
    //autoLoad: {params:{start:0, limit:100}},
    autoLoad: true,
    pageSize: 1000,
     
    proxy: {
        type: 'ajax',
        url: '/eduteca/web/app.php/admin/userList',
        reader: 
        {
            root: 'users',
            totalProperty: 'totalCount'
        }
    }
});

