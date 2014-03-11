/**
 * Created by Thammarak.
 * Date: 2/6/2556
 * Time: 15:44 น.
 */
Ext.define('Mam.view.SearchAppointment', {
    extend: 'Ext.dataview.List',
    xtype: 'searchappointment',
    requires: [
        'Ext.dataview.List',
        'Ext.Toolbar'
    ],
    config: {
        itemId: 'searchAppointment',
        offlineMode: false,
        title: 'ค้นหาตารางนัดหมาย',
        grouped: true,
        itemTpl: [
            "<div style='font-weight:bold '>{event}</div>",
            "<div style='padding-top: 10px;'>{title}</div>",
            "<div>{place}</div>"],
        items: [
            {
                xtype: 'toolbar',
                docked: 'top',
                items: [
                    {
                        itemId: 'appointmentSearchField',
                        xtype: 'searchfield',
                        placeHolder: 'หัวข้อ สถานที่ รายละเอียด.'
                    },
                    {
                        itemId: 'beginSearchAppointment',
                        xtype: 'button',
                        iconCls: 'search',
                        text: 'ค้นหา'
                    }
                ]
            }
        ]
    }
});