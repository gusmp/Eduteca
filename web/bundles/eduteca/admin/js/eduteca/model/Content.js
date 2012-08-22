Ext.define('Eduteca.model.Content', {
    extend: 'Ext.data.Model',
    idProperty: 'contentId',
    requires : [
        'Eduteca.model.Course',
        'Eduteca.model.User'
    ],
    fields: [
        { name: 'contentId'  , type: 'int'     },
        { name: 'title'      , type: 'string'  },
        { name: 'description', type: 'string'  },
        { name: 'path'       , type: 'string'  },
        { name: 'published'  , type: 'boolean' },
        { name: 'date'       , type: 'date'    , dateFormat:'d-m-Y H:i:s'}
    ],      
    
    validations: [
        { field: 'title', type: 'presence' },
        { field: 'title', type: 'length', min: 2, max: 100},
        { field: 'description', type: 'presence' },
        { field: 'description', type: 'presence', min: 2, max: 100}
    ],

    proxy: 
    {
        type: 'rest',
        appendId: true,
        url: '/eduteca/web/app.php/admin/content',
        reader: 
        {
            type: 'json',
            root: 'contents'
        }
    },
    
    associations: [
    { 
        name: 'courses', 
        type: 'belongsTo', 
        model: 'Eduteca.model.Course', 
        foreignKey: 'courseId', 
        primaryKey: 'contentId', 
        getterName:'getCourse', 
        setterName:'setCourse', 
        associationKey:'courses'
    },
    { 
        name: 'users', 
        type: 'belongsTo', 
        model: 'Eduteca.model.User', 
        foreignKey: 'userId', 
        primaryKey: 'contentId', 
        getterName:'getUser', 
        setterName:'setUser', 
        associationKey:'users'
    }]
});


