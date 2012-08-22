Ext.Loader.setConfig({
    enabled: true
});

Ext.application({
    name: 'Eduteca',
	appFolder: '/eduteca/web/bundles/eduteca/mobileWeb/app',

	requires: [
        'Ext.form.Panel',
	'Ext.field.*',
	'Ext.tab.Panel',
	'Ext.MessageBox',
        'Ext.form.FieldSet',
        'Ext.List'
    ],
	
    views: ['Eduteca.view.Presentation', 'Eduteca.view.SearchContent', 'Eduteca.view.Registration', 'Eduteca.view.About' ],

    controllers: ['Eduteca.controller.Registration', 'Eduteca.controller.SearchContent'],
	
    icon: {
        '57': 'resources/icons/Icon.png',
        '72': 'resources/icons/Icon~ipad.png',
        '114': 'resources/icons/Icon@2x.png',
        '144': 'resources/icons/Icon~ipad@2x.png'
    },

    isIconPrecomposed: true,

    startupImage: {
        '320x460': 'resources/startup/320x460.jpg',
        '640x920': 'resources/startup/640x920.png',
        '768x1004': 'resources/startup/768x1004.png',
        '748x1024': 'resources/startup/748x1024.png',
        '1536x2008': 'resources/startup/1536x2008.png',
        '1496x2048': 'resources/startup/1496x2048.png'
    },

    launch: function() {
        // Destroy the #appLoadingIndicator element
        Ext.fly('appLoadingIndicator').destroy();

        // Initialize the main view

        Ext.Viewport.add({
            //first we define the xtype, which is tabpanel for the Tab Panel component
            xtype: 'tabpanel',
            tabBarPosition: 'bottom',
            items: 
            [
                {
                    xtype: 'presentationPanel',
                    title: 'Eduteca',
                    iconCls: 'favorites'
		},
		{
                    xtype: 'searchContentPanel',
                    title: 'Buscar contenido',
                    iconCls: 'bookmarks'
		},
		{
                    xtype: 'registrationPanel',
                    title: 'Registrar usuario',
                    iconCls: 'user'
		},
		{
                    xtype: 'aboutPanel',
                    title: 'Sobre Eduteca',
                    iconCls: 'info'
		}
            ]
        });
    },

    onUpdated: function() {
        Ext.Msg.confirm(
            "Actualización de la aplicación",
            "Esta aplicación se ha actualizado exitosamente a la última versión. ¿Recargar ahora?",
            function(buttonId) {
                if (buttonId === 'yes') {
                    window.location.reload();
                }
            }
        );
    }
});
