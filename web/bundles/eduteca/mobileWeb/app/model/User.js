Ext.define('Eduteca.model.User', {
    extend: 'Ext.data.Model',
    config: 
    {
        idProperty: 'userId',
	fields: [
            { name: 'userId'    , type: 'int' },
            { name: 'login'     , type: 'string'},
            { name: 'password'  , type: 'string'},
            { name: 'name'      , type: 'string'},
            { name: 'surname1'  , type: 'string'},
            { name: 'surname2'  , type: 'string'},
            { name: 'approved'  , type: 'boolean'},
            { name: 'email'     , type: 'string'},
            { name: 'groupId'   , type: 'int'}
	],
	validations: [
            { field: 'login'   , type: 'presence'  },
            { field: 'login'   , type: 'length', min: 2, max: 100},
            { field: 'password', type: 'presence'  },
            { field: 'password', type: 'length', min: 2, max: 100},
            { field: 'name'    , type: 'presence' },
            { field: 'name'    , type: 'length', min: 2, max: 100},
            { field: 'surname1', type: 'presence' },
            { field: 'surname1', type: 'length', min: 2, max: 100},
            { field: 'surname2', type: 'length', max: 100},  
            { field: 'email'   , type: 'email'},
	],
	proxy: 
	{
            type: 'rest',
            appendId: true,
            url: '/eduteca/web/app.php/mobile/user',
            reader: 
            {
                type: 'json',
		rootProperty: 'users'
            }
	}
    }
});
