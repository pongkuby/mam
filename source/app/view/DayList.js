/**
 * Created by Thammarak.
 * Date: 23/1/2557
 * Time: 7:40 น.
 */
Ext.define('Mam.view.DayList', {
    extend: 'Ext.dataview.List',
    xtype: 'daylist',
    config: {
        currentDate: null,
        uid: null,
        mainCurrentView: null,
        modal: true,
        hideOnMaskTap: true,
        data: [
            { title: 'Item 1' },
            { title: 'Item 2' },
            { title: 'Item 3' },
            { title: 'Item 4' }
        ],
        itemTpl:
            '<div style="font-weight:bold;">{event}</div>' +
                '<div style="margin: 5px;">{title}</div>'
    }
});