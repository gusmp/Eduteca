Ext.define('Eduteca.store.User', {
    extend: 'Ext.data.Store',
    model: 'Eduteca.model.User',
    //autoLoad: {params:{start:0, limit:10}},
    pageSize: 10,
     
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

