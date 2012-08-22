Ext.define('Eduteca.model.Content', {
    extend: 'Ext.data.Model',
    config:
    {
        idProperty: 'contentId',

        fields: [
            { name: 'contentId'  , type: 'int'     },
            { name: 'title'      , type: 'string'  },
            { name: 'description', type: 'string'  },
            { name: 'path'       , type: 'string'  },
            { name: 'published'  , type: 'boolean' },
            { name: 'date'       , type: 'date'    , dateFormat:'d-m-Y H:i:s'}
        ]      
    }
});


