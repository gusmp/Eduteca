Ext.define('Eduteca.controller.SearchContent', {
    extend: 'Ext.app.Controller',
    id    : 'searchContentController',
    config:
    {
        models: ['Eduteca.model.Course','Eduteca.model.Content'],
        stores: ['Eduteca.store.CourseCombo', 'Eduteca.store.Content']
    },

    init: function()
    {
        this.control({

            '#btSearchContent' : 
            {
                tap: this.searchContent
            }
	});
    },
	
    searchContent: function(bt)
    {
        Ext.Ajax.request({
            url: '/eduteca/web/app.php/mobile/contentList',
            method: 'GET',
            disableCaching: false,

            params: 
            {
                courseId: bt.up('container').items.get('searchContentCourseId').getValue(),
                title: bt.up('container').items.get('searchContentTitle').getValue(),
                description: bt.up('container').items.get('searchContentDescription').getValue()
            },
            success: function(response) 
            {
                var data = Ext.decode(response.responseText);
                if (data.success == false)
                {
                    Ext.Msg.alert('Eduteca', 'Error al buscar contenidos:' + Ext.decode(response.responseText).message, Ext.emptyFn);
                }
                else
                {
                    Ext.StoreMgr.get('Content').removeAll(true);
                    Ext.getCmp('listSearchContent').refresh(this,null);
                    Ext.StoreMgr.get('Content').add(data.contents);
                    Ext.getCmp('tabPanelSearchContent').setActiveItem(1);
                }
            },
            failure: function(response) 
            {
                Ext.Msg.alert('Eduteca', 'Error al buscar contenidos', Ext.emptyFn);  
            }
        });
    }
});