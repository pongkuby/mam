/**
 * Created by Thammarak.
 * Date: 2/6/2556
 * Time: 11:01 น.
 */
Ext.define('Mam.view.SearchEmployee', {
    extend: 'Ext.dataview.List',
    xtype: 'searchemployee',
    requires: [
        'Ext.dataview.List',
        'Ext.Toolbar'
    ],
    config: {
        title: 'ค้นหาเบอร์โทรพนักงาน',
        layout: 'fit',
        disableSelection: true,
        items: [
            {
                xtype: 'toolbar',
                docked: 'top',
                items: [
                    {
                        id: 'employeeSearchField',
                        xtype: 'searchfield',
                        placeHolder: 'ชื่อ นามสกุล หน่วยงาน.',
                        config:{
                            itemId: 'employeeSearchField'
                        }
                    },
                    {
                        id: 'beginSearchEmployee',
                        xtype: 'button',
                        iconCls: 'search',
                        text: 'ค้นหา',
                        config:{
                            itemId: 'beginSearchEmployee'
                        }
                    }
                ]
            }
        ]
    }
});