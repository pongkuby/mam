/**
 * Created by Thammarak.
 * Date: 1/6/2556
 * Time: 10:41 น.
 */
Ext.define('Mam.view.phone.SearchCalendar', {
    extend: 'Ext.dataview.List',
    xtype: 'searchcalendar',
    requires: [
        'Ext.dataview.List',
        'Ext.Toolbar'
    ],
    config: {
        itemId: 'searchCalendar',
        uid: '',
        title: 'ค้นหาปฏิทิน',
        layout: 'fit',
        items: [
            {
                xtype: 'toolbar',
                docked: 'top',
                itemTpl: '<div>{firstName} {lastName} - {division}</div>',
                items: [
                    {
                        itemId: 'calendarSearchField',
                        xtype: 'searchfield',
                        placeHolder: 'ชื่อ นามสกุล หน่วยงาน.'
                    },
                    {
                        itemId: 'beginSearchCalendar',
                        xtype: 'button',
                        iconCls: 'search'
                    }
                ]
            }
        ]
    }
});