Ext.define('Eduteca.store.Content', {
    extend: 'Ext.data.Store',
    model: 'Eduteca.model.Content',
    //autoLoad: {params:{start:0, limit:10}},
    pageSize: 10,
     
    proxy: {
        type: 'ajax',
        url: '/eduteca/web/app.php/admin/contentList',
        reader: 
        {
            root: 'contents',
            totalProperty: 'totalCount'
        }
    }
});

