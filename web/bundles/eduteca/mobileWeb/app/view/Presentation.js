Ext.define("Eduteca.view.Presentation", {
    extend: 'Ext.Container',
    alias: 'widget.presentationPanel',

    initialize: function () 
    {
        this.callParent(arguments);
        
        var mainForm = Ext.create('Ext.form.Panel', 
        {
            iconCls: 'user',
            layout: 'vbox',
            items: [
                {
                    xtype: 'textfield',
                    readOnly:'true',
                    value: ''
                }
            ]
        });
        
         var topToolbar = {
            xtype: "toolbar",
            title: 'Eduteca',
            docked: "top"
        };

	this.add([topToolbar, mainForm]);
		
    },
    config: {
        layout: {
            type: 'fit'
        }
    }
});
