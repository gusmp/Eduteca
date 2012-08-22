Ext.Loader.setConfig({enabled:true});

Ext.require('Ext.container.Viewport');


Ext.application({
    name: 'Eduteca',
    
    appFolder: '/eduteca/web/bundles/eduteca/admin/js/eduteca',
    
    controllers: ['Courses','Contents','Users'],
    
    launch: function() 
    {
       Ext.QuickTips.init();
       
       Ext.create('Ext.container.Viewport', {
            title: 'Center Layout',
            layout: 'border',
            items: [ 
                {
                    xtype: 'panel',
                    region: 'north',
                    html: 'Eduteca',
                    bodyStyle: 'background:#ffc; padding:10px;font-weight:bold'
                },
                {
                    xtype: 'treeMenu',
                    region: 'west'
                },
                {
                    xtype: 'panel',
                    id: 'centerPanel'
                },
                {
                    xtype: 'panel',
                    region: 'south',
                    html: '',
                    bodyStyle: 'background:#ffc; padding:10px;font-weight:bold'
                }
            ]
        });
    }
});


