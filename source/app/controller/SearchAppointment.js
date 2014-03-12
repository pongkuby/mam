/**
 * Created by Thammarak.
 * Date: 2/6/2556
 * Time: 15:47 น.
 */
Ext.define('Mam.controller.SearchAppointment', {
    extend: 'Ext.app.Controller',

    config: {
        requires: [
            'Mam.Util'
        ],

        refs: {
            searchAppointment: 'searchappointment',
            appointmentSearchField: 'searchappointment #appointmentSearchField',
            beginSearchAppointment: 'searchappointment #beginSearchAppointment',
            addButton: 'panel #addButton',
            main: 'main'
        },

        control: {
            searchAppointment: {
                initialize: 'onInitialize',
                itemtap: 'onItemTap'
            },
            appointmentSearchField: {
                keyup: 'onKeyup',
                clearicontap: 'onClearSearchTap'
            },
            beginSearchAppointment: {
                tap: 'doSearch'
            },
            main: {
                push: 'onPushView'
            }
        },
        uid: null,
        keyword: '',
        currentView: 'month'
    },

    init: function () {
        this.setUid(Ext.Object.fromQueryString(window.location.search.substring(1)).uid);
    },

    launch: function () {
        if (Ext.Object.fromQueryString(window.location.search).currentview == null) {
            this.setCurrentView("month");
        }
        else {
            this.setCurrentView(Ext.Object.fromQueryString(window.location.search).currentview);
        }
    },

    onInitialize: function () {
        if(Ext.os.is.Phone)
        {
            this.getBeginSearchAppointment().setText("");
        }
        var store = Ext.create('Mam.store.Appointments', {
            storeId: 'searchAppointment'
        });
        var localStore = Ext.getStore("appointmentsOffline");
        if (localStore == null) {
            localStore = Ext.create("Mam.store.AppointmentsOffline");
        }
        localStore.load(
            function (records, operation, success) {
                for (var i = 0; i < records.length; i++) {
                    store.add(records[i].data);
                }
                store.sync();
                store.filter("title", /""/);
            }, this
        );
        this.getSearchAppointment().setStore(store);
    },

    onKeyup: function (field, e, eOpts) {
        if (e.event.keyCode == 13) {
            this.doSearch();
        }
    },

    /**
     * Called when the user taps on the clear icon in the search field.
     * It simply removes the f
     * ilter form the store
     */
    onClearSearchTap: function () {
        var store = this.getSearchAppointment().getStore();
        store.filter("title", /""/);
        Ext.getCmp('appointmentSearchField').focus('', 20);
    },

    onItemTap: function (list, index, target, record, e, eOpts) {
        window.location = Mam.Util.getServerUrl() + "/mam/view_meeting.php?aid="
            + record.get('appId') + "&currentview=" + this.getCurrentView()
            + "&uid=" + this.getUid();
    },

    doSearch: function () {
        var store = this.getSearchAppointment().getStore();
        store.clearFilter();
        var value = this.getAppointmentSearchField().getValue();
        this.setKeyword(value);
        if (value.trim() == "") {
            this.onClearSearchTap();
        }
        else {
            store.filter(
                Ext.create('Ext.util.Filter', {
                        filterFn: function (item) {
                            var matchKeyword = new RegExp(this.getKeyword());
                            if (matchKeyword.test(item.get('title'))) {
                                return true;
                            }
                            else {
                                if (matchKeyword.test(item.get('detail'))) {
                                    return true;
                                }
                                else {
                                    if (matchKeyword.test(item.get('place'))) {
                                        return true;
                                    }
                                    return false
                                }
                            }
                        },
                        rootProperty: 'data',
                        scope: this
                    }
                )
            );
        }
    },

    onPushView: function (navView, pushView, eOpts) {
        if (pushView.id == "searchAppointment") {
            this.getAddButton().hide();
        }
    }
});
