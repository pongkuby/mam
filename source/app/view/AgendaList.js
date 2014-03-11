/**
 * Created by Thammarak.
 * Date: 30/5/2556
 * Time: 16:58 น.
 */
Ext.define('Mam.view.AgendaList', {
    extend: 'Ext.dataview.List',
    xtype: 'agendalist',
    config: {
        data: [
            {
                event: '08:00 - 10:30',
                title: 'ประชุมพัฒนากระบวนงาน',
                appDate: '20-05-2556'
            },
            {
                event: '15:00 - 16:30',
                title: 'ประชุมพัฒนากระบวนงาน',
                appDate: '20-05-2556'
            },
            {
                event: '08:00 - 16:30',
                title: 'ประชุมพัฒนากระบวนงาน',
                appDate: '23-05-2556'
            },
            {
                event: '13:00 - 16:30',
                title: 'ประชุมพัฒนากระบวนงาน',
                appDate: '30-05-2556'
            }
        ],
        itemTpl: '<div>{event}</div>' + '<div>{title}</div>'
    }
});