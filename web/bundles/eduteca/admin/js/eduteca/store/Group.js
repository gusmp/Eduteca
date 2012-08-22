Ext.define('Eduteca.store.Group', {
    extend: 'Ext.data.Store',
    model: 'Eduteca.model.Group',
    pageSize: 10,
    autoLoad: true,
     
    proxy: {
        type: 'ajax',
        url: '/eduteca/web/app.php/admin/groupList',
        reader: 
        {
            root: 'groups',
            totalProperty: 'totalCount'
        }
    }
    
    
});

