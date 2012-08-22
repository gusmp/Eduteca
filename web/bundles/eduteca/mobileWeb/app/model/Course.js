Ext.define('Eduteca.model.Course', {
    extend: 'Ext.data.Model',
    
    config: 
    {
        idProperty: 'courseId',
        fields: [
            { name: 'courseId'  , type: 'int' },
            { name: 'courseName', type: 'string'},
        ]
    }
});


