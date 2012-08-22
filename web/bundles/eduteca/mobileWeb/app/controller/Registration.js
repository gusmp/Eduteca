Ext.define('Eduteca.controller.Registration', {
    extend: 'Ext.app.Controller',
    id    : 'registrationController',
    config:
    {
        models: ['Eduteca.model.User']
    },

    init: function()
    {
        this.control({

            '#btNewUser' : 
            {
                tap: this.newUser
            }
        });
    },
	
    newUser: function(bt)
    {
        var user = Ext.create('Eduteca.model.User', bt.up('panel').getValues());
	var errors = user.validate();
        
        if (errors.isValid() == true)
        {
            user.save(
            {
                success: function(rec, op) 
                {
                    Ext.Msg.alert('Eduteca',
                        'El usuario ' + Ext.decode(op._response.responseText).login + ' ha sido registrado con éxito',
                        Ext.emptyFn
                    );
                },
                failure: function(rec, op) 
                {
                    Ext.Msg.alert('Eduteca', 'El usuario ya existe', Ext.emptyFn); 
                }
            });
        }
	else
	{
            Ext.Msg.alert('Eduteca', 
                'El formulario tiene errores<br/>Campo: ' + errors.items[0]._field + '(' + errors.items[0]._message +')', 
		Ext.emptyFn);
	}
    }
});