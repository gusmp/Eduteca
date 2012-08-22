Ext.define('Eduteca.controller.Courses', {
    extend: 'Ext.app.Controller',
    id    : 'courseController',
    stores: ['Course'],
    models: ['Course'],
    views : ['TreeMenu', 'course.ListCourseForm', 'course.NewCourseForm','course.EditCourseForm' ], 

    init: function()
    {
        this.control({

            '#mygrid' : {
                itemclick: this.bindGridToPanel
            },
            
            '#treeMenu' : {
                itemclick: this.treeOptions
            },
            
            '#btCourseSave': {
                click: this.btCourseSave
            },
            
            '#btCourseUpdate': {
                click: this.btCourseUpdate
            }
            
            /*
            '#gridEditCourse': {
                click: this.gridEditCourse
            }
            */
        });
    },
    
    bindGridToPanel: function(grid, record) {
        this.getPanel().updateDetail(record.data);
    },
    
    treeOptions: function(tree, record)
    {
        if (record.data.id == 'trOpCourseNew')
        {
            new Eduteca.view.course.NewCourseForm({}).show();
        }
        else if (record.data.id == 'trOpCourseDel')
        {
            new Eduteca.view.course.ListCourseForm({}).show();
        }
        else if (record.data.id == 'trOpCourseMod')
        {
            new Eduteca.view.course.ListCourseForm({}).show();
        }
    },
    
    btCourseSave: function(bt)
    {
        this.courseSaveUpdate(bt,false);
    },
    
    btCourseUpdate: function(bt)
    {
        this.courseSaveUpdate(bt,true);
    },
    
    courseSaveUpdate: function(bt, refreshData)
    {
        var form = bt.up('window').down('form').getForm();
        
        var course = Ext.create('Eduteca.model.Course', form.getValues());
        var errors = course.validate();
        
        if (errors.isValid() == true)
        {
            course.save(
            {
                success: function(rec, op) 
                {
                    bt.up('window').close();
                    if (refreshData == true)
                    {
                        Ext.getCmp('gridCourse').store.reload();
                    }
                },
                failure: function(rec, op) 
                {
                    Ext.Msg.show(
                    {
                        title: 'Eduteca',
                        msg: op.request.scope.reader.jsonData["message"],
                        buttons: Ext.MessageBox.YES,
                        icon: Ext.MessageBox.ERROR
                    }); 
                }
            });
        }
    }
    
    /*
    gridEditCourse: function(grid, record, item, index, event, ops)
    {
        // record.validate().isValid()
        Ext.Msg.alert('======' + record.data.courseId);
        
    }
    */

});

