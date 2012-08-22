Ext.define('Eduteca.store.CourseCombo', {
    extend: 'Ext.data.Store',
    model: 'Eduteca.model.Course',
    //autoLoad: {params:{start:0, limit:100}},
    autoLoad: true,
    pageSize: 1000,
     
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

