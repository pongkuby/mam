/**
 * Created by Thammarak.
 * Date: 30/1/2557
 * Time: 15:47 น.
 */
Ext.define('Mam.view.BookingList', {
    extend: 'Ext.dataview.List',
    xtype: 'bookinglist',
    config: {
        title: 'ตารางจองห้องประชุมกปน.',
        itemTpl: '<div style="font-weight:bold;">{startTime} - {endTime}</div>' +
            '<div style="margin: 5px;">{subject} - {room}</div>',
        grouped: true
    }
});