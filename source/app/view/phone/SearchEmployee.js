/**
 * Created by Thammarak.
 * Date: 2/6/2556
 * Time: 11:01 น.
 */
Ext.define('Mam.view.phone.SearchEmployee', {
    extend: 'Ext.dataview.List',
    xtype: 'searchemployee',
    requires: [
        'Ext.dataview.List',
        'Ext.Toolbar'
    ],
    config: {
        itemId: 'searchEmployee',
        uid:'',
        title: 'ค้นหาเบอร์โทร',
        layout: 'fit',
        disableSelection: true,
        items: [
            {
                xtype: 'toolbar',
                docked: 'top',
                items: [
                    {
                        itemId: 'employeeSearchField',
                        xtype: 'searchfield',
                        placeHolder: 'ชื่อ นามสกุล หน่วยงาน.'
                    },
                    {
                        itemId: 'beginSearchEmployee',
                        xtype: 'button',
                        iconCls: 'search'
                    }
                ]
            }
        ]
    }
});