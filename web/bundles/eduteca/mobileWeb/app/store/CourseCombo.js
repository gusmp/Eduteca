Ext.define('Eduteca.store.CourseCombo', {
    extend: 'Ext.data.Store',
    
    config: 
    {
        model: 'Eduteca.model.Course',
        autoLoad: true,
        pageSize: 1000,
     
        proxy: 
        {
            type: 'ajax',
            url: '/eduteca/web/app.php/mobile/courseList',
            reader: 
            {
                rootProperty: 'courses',
                totalProperty: 'totalCount'
            }
        }
    }
});

