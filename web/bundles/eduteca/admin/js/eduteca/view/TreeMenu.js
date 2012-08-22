Ext.define('Eduteca.view.TreeMenu',{
    extend      : 'Ext.tree.TreePanel',
    alias       : 'widget.treeMenu',
    id          : 'treeMenu',
    rootVisible : false,
    title       : 'Opciones',
    width       : 200,
    collapsible : true,
    
    initComponent: function() {
        
        this.store = Ext.create('Ext.data.TreeStore', {
            root: {
                expanded: true,
                children: [
                    { 
                        text: "Cursos", 
                        expanded: true,
                        children: [
                            { id: 'trOpCourseNew', text: "Nuevo", leaf: true },
                            { id: 'trOpCourseDel', text: "Borrar", leaf: true },
                            { id: 'trOpCourseMod', text: "Modificar", leaf: true }
                        ]
                    },
                    { 
                        text: "Contenidos", 
                        expanded: true,
                        children: [
                            { id: 'trOpContentNew', text: "Nuevo", leaf: true },
                            { id: 'trOpContentDel', text: "Borrar", leaf: true },
                            { id: 'trOpContentMod', text: "Modificar", leaf: true }
                        ]
                    },
                    { 
                        text: "Usuarios", 
                        expanded: true,
                        children: [
                            { id: 'trOpUserNew', text: "Nuevo", leaf: true },
                            { id: 'trOpUserDel', text: "Borrar", leaf: true },
                            { id: 'trOpUserMod', text: "Modificar", leaf: true }
                        ]
                    },
                    {
                        text: "Salir",
                        id: 'logout',
                        leaf: true,
                        href: 'admin/logout'
                    }
                ]} 
        });

        this.callParent(arguments);
    }
    
});


