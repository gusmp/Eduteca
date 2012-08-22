Ext.define('Eduteca.store.Course', {
    extend: 'Ext.data.Store',
    model: 'Eduteca.model.Course',
    //autoLoad: {params:{start:0, limit:10}},
    pageSize: 10,
     
    proxy: {
        type: 'ajax',
        url: '/eduteca/web/app.php/admin/courseList',
        reader: 
        {
            root: 'courses',
            totalProperty: 'totalCount'
        }
    }
});

