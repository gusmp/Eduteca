Ext.define('Eduteca.store.Content', {
    extend: 'Ext.data.Store',
    id: 'contentStore',
    config: 
    {
        model: 'Eduteca.model.Content',
        pageSize: 100,
        autoLoad: true,
        proxy: 
        {
            type: 'ajax',
            url: '/eduteca/web/app.php/mobile/contentList',
            reader: 
            {
                rootProperty: 'contents',
                totalProperty: 'totalCount'
            }
        }
    }
});

