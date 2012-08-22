Ext.define('Eduteca.model.Course', {
    extend: 'Ext.data.Model',
    idProperty: 'courseId',
    fields: [
        { name: 'courseId'  , type: 'int' },
        { name: 'courseName', type: 'string'},
    ],
    
    validations: [
        { field: 'courseName', type: 'presence' },
        { field: 'courseName', type: 'length' , min: 2, max: 100}
    ],

    proxy: 
    {
        type: 'rest',
        appendId: true,
        url: '/eduteca/web/app.php/admin/course',
        reader: 
        {
            type: 'json',
            root: 'courses'
        }
    },
    
    associations: [
    { 
        name: 'contents', 
        type: 'hasMany', 
        model: 'Eduteca.model.Content', 
        foreignKey: 'contentId', 
        primaryKey: 'courseId', 
        getterName:'getContents', 
        setterName:'setContents', 
        associationKey:'contents'
    }]
});


