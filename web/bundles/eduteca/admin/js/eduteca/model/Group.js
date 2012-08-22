Ext.define('Eduteca.model.Group', {
    extend: 'Ext.data.Model',
    idProperty: 'groupId',
    fields: [
        { name: 'groupId'  , type: 'int' },
        { name: 'groupName', type: 'string'},
    ],
    
    validations: [
        { field: 'groupName', type: 'presence' },
        { field: 'groupName', type: 'length' , min: 2, max: 100}
    ],

    proxy: 
    {
        type: 'rest',
        appendId: true,
        url: '/eduteca/web/app.php/admin/group',
        reader: 
        {
            type: 'json',
            root: 'groups'
        }
    },
    
    associations: [
    { 
        name: 'users', 
        type: 'hasMany', 
        model: 'Eduteca.model.User', 
        foreignKey: 'userId', 
        primaryKey: 'groupId', 
        getterName:'getUsers', 
        setterName:'setUsers', 
        associationKey:'users'
    }]
    

    
});


