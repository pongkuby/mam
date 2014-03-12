/**
 * Created by Thammarak.
 * Date: 30/1/2557
 * Time: 15:34 น.
 */
Ext.define('Mam.controller.Booking', {
    extend: 'Ext.app.Controller',

    requires: [
        'Mam.Util',
        'Mam.view.BookingList',
        'Mam.model.Booking'
    ],

    config: {
        refs: {
            main: 'main',
            addButton: 'panel #addButton',
            menuButton: 'main #menuButton',
            bookingList: 'bookinglist',
            menuPanel: 'main #menuPanel'
        },

        control: {
            main: {
                push: 'onPushView'
            },

            bookingList: {
                initialize: 'onInitialize'
            }
        }
    },

    onInitialize: function (list, eOpts) {
        var myStore = Ext.create("Ext.data.Store", {
            model: 'Mam.model.Booking',
            proxy: {
                type: 'jsonp',
                url: Mam.Util.getServerUrl() + '/service/getbookingroombymonth/'
                    + new Date().yyyymmdd(),
                callbackKey: 'callback',
                reader: {
                    type: 'json',
                    rootProperty: 'bookingrooms'
                }
            },
            grouper: {
                sortProperty: 'bookDate',
                groupFn: function (record) {
                    if (record.get('bookDate') != null) {
                        return record.get('bookDate').toString().split('GMT')[0];
                    }
                }},
            sorters: [
                {
                    property: 'bookDate',
                    direction: 'ASC'
                },
                {
                    property: 'startTime',
                    direction: 'ASC'
                }
            ],
            autoLoad: true
        });
        list.setMasked({
            xtype: 'loadmask',
            message: 'Loading..'
        });
        list.setStore(myStore);
        list.refresh();
        list.setEmptyText("ไม่พบตารางจองห้องประชุม");
    },

    onPushView: function (navView, pushView, eOpts) {
        if (pushView.xtype == "bookinglist") {
            this.getMenuButton().hide();
            this.getAddButton().hide();
        }
    }
});