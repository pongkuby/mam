/**
 * ใช้เตือน Appointment
 * Created by Thammarak.
 * Date: 4/2/2557
 * Time: 10:32 น.
 */
Ext.define('Mam.view.AppointmentAlert', {
    extend: 'Ext.dataview.List',
    xtype: 'appointmentalert',
    config: {
        uid: null,
        mainCurrentView: null,
        main:null,
        modal: true,
        hideOnMaskTap: true,
        fullscreen: false,
        data: [
            { title: 'Item 1' },
            { title: 'Item 2' },
            { title: 'Item 3' },
            { title: 'Item 4' }
        ],
        itemTpl:
            '<div style="font-weight:bold;">{start:date("F j, Y H:i:s")}</div>' +
                '<div style="margin: 5px;">{title}</div>',
        style: 'display: inline-block;font-size:14px'
    }
});