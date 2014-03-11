/**
 * Created by Thammarak.
 * Date: 27/1/2557
 * Time: 7:37 น.
 */
Ext.define('Mam.controller.DayList', {
    extend: 'Ext.app.Controller',

    requires: [
        'Mam.view.DayList',
        'Mam.Util',
        'Mam.model.Appointment',
        'Ext.data.proxy.JsonP'
    ],

    config: {
        refs: {
            daylist: 'daylist'
        },

        control: {
            daylist: {
                initialize: 'initialize',
                itemtap: 'itemtap'
            }
        }
    },

    initialize: function (list, eOpts) {
        var myStore = Ext.create("Ext.data.Store", {
            model: 'Mam.model.Appointment',
            proxy: {
                type: 'jsonp',
                url: Mam.Util.getServerUrl() + '/service/getdailyappointments/' + list.getUid() + '/'
                    + Mam.Util.formatDate(list.getCurrentDate()),
                reader: {
                    type: 'json',
                    rootProperty: 'appointments'
                }
            },
            autoLoad: true
        });
        list.setMasked({
            xtype: 'loadmask',
            message: 'Loading..'
        });
        list.setStore(myStore);
        list.refresh();
        list.setEmptyText("ไม่พบตารางนัดหมาย");
    },

    itemtap: function (list, index, target, record, e, eOpts) {
        if (record.get("appType") != 0) {
            window.location = Mam.Util.getServerUrl() + "/mam/view_meeting.php?aid="
                + record.get("appId") + "&uid=" + list.getUid()
                + "&currentview=" + list.getMainCurrentView();
        }
    }
});