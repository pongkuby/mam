/**
 * Created by Thammarak.
 * Date: 4/2/2557
 * Time: 10:42 น.
 */
Ext.define('Mam.controller.AppointmentAlert', {
    extend: 'Ext.app.Controller',

    requires: [
        'Mam.view.AppointmentAlert',
        'Mam.Util',
        'Mam.model.Appointment',
        'Ext.data.proxy.JsonP'
    ],

    config: {
        refs: {
            alert: 'appointmentalert',
            closeAlertButton: '#closeAlertButton',
            alertOption: '#alertOption'
        },

        control: {
            alert: {
                initialize: 'initialize',
                itemtap: 'itemtap'
            },
            closeAlertButton: {
                tap: 'onCloseAlert'
            }
        }
    },

    initialize: function (list, eOpts) {
        var currentDate = new Date();
        var h = Math.ceil(Ext.Viewport.getWindowHeight() * 0.7),
            w = Math.ceil(Ext.Viewport.getWindowWidth() * 0.6);
        list.setHeight(h);
        list.setWidth(w);
        var myStore = Ext.create("Ext.data.Store", {
            model: 'Mam.model.Appointment',
            proxy: {
                type: 'jsonp',
                url: Mam.Util.getServerUrl() + '/service/getappointmentalert/' + list.getUid() + '/'
                    + currentDate.yyyymmdd(),
                reader: {
                    type: 'json',
                    rootProperty: 'appointments'
                }
            },
            autoLoad: false,
            sorters: [
                {
                    property: 'start',
                    direction: 'ASC'
                },
                {
                    property: 'startTime',
                    direction: 'ASC'
                }
            ]
        });
        myStore.load(
            function (records, operation, success) {
                if (records.length > 0) {
                    list.showBy(list.getMain());
                }
            }, list
        );
        list.setMasked({
            xtype: 'loadmask',
            message: 'Loading..'
        });
        list.setStore(myStore);
        list.refresh();
        list.setEmptyText("ไม่พบการแจ้งเตือนตารางนัดหมาย");
    },

    itemtap: function (list, index, target, record, e, eOpts) {
        //ส่ง Comma -> %2C
        return;
        if (record.get("appType") != 0) {
            window.location = Mam.Util.getServerUrl() + "/mam/view_meeting.php?aid="
                + record.get("appId") + "&uid=" + list.getUid()
                + "&currentview=" + list.getMainCurrentView();
        }
    },

    onCloseAlert: function (button, e, eOpts) {
        this.getAlert().hide();
    }
});