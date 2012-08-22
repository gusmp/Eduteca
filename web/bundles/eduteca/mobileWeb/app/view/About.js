Ext.define("Eduteca.view.About", {
    extend: 'Ext.form.Panel',
    alias: 'widget.aboutPanel',
    
    initialize: function () 
    {
        this.callParent(arguments);
        
        var mainForm = Ext.create('Ext.form.Panel', 
        {
            iconCls: 'user',
            layout: 'vbox',
            items: [
                {
                    xtype: 'textareafield',
                    readOnly:'true',
                    value: 'Eduteca es una plataforma open source para el intercambio de material docente'
                }
            ]
        });
        
         var topToolbar = {
            xtype: "toolbar",
            title: 'Sobre Eduteca',
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
