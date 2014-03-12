/**
 * Created by Thammarak.
 * Date: 1/6/2556
 * Time: 11:04 น.
 */
Ext.define('Mam.controller.SearchCalendar', {
    extend: 'Ext.app.Controller',

    config: {
        requires: [
            'Mam.Util'
        ],

        views: [
            'SearchCalendar'
        ],

        refs: {
            searchCalendar: 'searchcalendar',
            main: 'main',
            mainCalendar: 'main #viewMainCalendar',
            menuButton: 'main #menuButton',
            agendaList: 'maincalendar #viewEmployeeAgendaList',
            employeeCalendar:'maincalendar #viewEmployeeCalendar',
            calendarSearchField: 'searchcalendar #calendarSearchField',
            beginSearchCalendar: 'searchcalendar #beginSearchCalendar',
            viewMonth: 'maincalendar #viewMonth',
            viewWeek: 'maincalendar #viewWeek',
            viewDay: 'maincalendar #viewDay',
            viewAgenda: 'maincalendar #viewAgenda'
        },

        control: {
            searchCalendar: {
                itemtap: 'onItemTap',
                initialize: 'onInitialize'
            },
            calendarSearchField: {
                keyup: 'onKeyup',
                clearicontap: 'onClearSearchTap'
            },
            beginSearchCalendar: {
                tap: 'doSearch'
            },
            main: {
                push: 'onPushView'
            },
            viewMonth: {
                tap: 'onViewMonthTap'
            },
            viewWeek: {
                tap: 'onViewWeekTap'
            },
            viewDay: {
                tap: 'onViewDayTap'
            },
            viewAgenda: {
                tap: 'onViewAgendaTap'
            }
        }
    },

    init: function () {

    },

    onInitialize: function () {
        if(Ext.os.is.Phone)
        {
            this.getBeginSearchCalendar().setText("");
        }
        var store = Ext.create('Mam.store.Employees', {
            storeId: 'searchCalendarStore',
            sorters: [
                {
                    property: 'firstName',
                    direction: 'ASC'
                }
            ]
        });
        this.getSearchCalendar().setStore(store);
        this.getSearchCalendar().setItemTpl(
            ["<div><img src='resources/icons/system-users-icon.png' style='padding-right: 10px;'>{firstName} {lastName}</div>",
                "<div><img src='resources/icons/position-icon.png'> {position}</div>",
                "<div><span><img src='resources/icons/division-icon.png'></span><span> {division}</span></div>"]);
    },

    onKeyup: function (field, e, eOpts) {
        if (e.event.keyCode == 13) {
            this.doSearch();
        }
    },

    /**
     * Called when the user taps on the clear icon in the search field.
     * It simply removes the filter form the store
     */
    onClearSearchTap: function () {
        var store = this.getSearchCalendar().getStore();
        var records = store.getRange();
        store.remove(records);
        var textField = Ext.ComponentQuery.query("#calendarSearchField")[0];
        textField.focus('', 30);
    },

    onItemTap: function (list, index, target, record, e, eOpts) {
        var vid = record.get('empId');
        var fullName = "ตารางนัดหมายของ " + record.get('firstName') + " " + record.get('lastName');
        var agenda = Ext.create('Ext.dataview.List', {
            itemId: 'viewEmployeeAgendaList',
            itemTpl: ['' +
                '<div style="font-weight:bold ">{event}</div>',
                '<div style="padding-top: 10px;">{title}</div>'
            ],
            grouped: true,
            layout: 'fit',
            hidden: true
        });
        var mainCal=null;
        if(Ext.os.is.Phone)
        {
            mainCal = Ext.create('Mam.view.phone.MainCalendar', {
                title: fullName,
                itemId: 'viewMainCalendar'
            });
        }
        else{
            mainCal = Ext.create('Mam.view.MainCalendar', {
                title: fullName,
                itemId: 'viewMainCalendar'
            });
        }
        mainCal.add(agenda);
        var yearStore = this.getAppointmentStore(vid);
        yearStore.load(function (records, operation, success) {
            var calendar = Ext.create('Ext.ux.TouchCalendar', {
                xtype: 'calendar',
                itemId: 'viewEmployeeCalendar',
                viewMode: "month",
                value: new Date(),
                enableEventBars: {
                    eventHeight: 'auto',
                    eventBarTpl: '<div>{event} {title}</div>'
                },
                viewConfig: {
                    weekStart: 0,
                    eventStore: yearStore,
                    timeSlotDateTpls: {
                        day: '<span class="hour">{date:date("g")}</span><span class="am-pm">{date:date("A")}</span>'
                    }
                }
            });
            this.getMenuButton().hide();
            mainCal.add(calendar);
            mainCal.setActiveItem(calendar);
            this.getMain().push(mainCal);
        }, this);
        var agendaStore = this.getAppointmentStore(vid);
        agendaStore.filter(
            new Ext.util.Filter({
                filterFn: function (record) {
                    return (record.get('start') >= new Date() || record.get('end') >= new Date());
                }
            })
        );
        agendaStore.sort(new Ext.util.Sorter({
            property: 'start',
            direction: 'ASC',
            sorterFn: function (o1, o2) {
                var v1 = new Date(o1.data.date);
                var v2 = new Date(o2.data.date);
                return v1 > v2 ? 1 : (v1 < v2 ? -1 : 0);
            }
        }));
        agenda.setMasked({
            xtype: 'loadmask',
            message: 'Loading..'
        });
        agenda.setStore(agendaStore);
        agendaStore.load(
            function (records, operation, success) {
                if (records.count > 0) {
                    agenda.refresh();
                }
                else {
                    agenda.setEmptyText("ไม่พบตารางนัดหมาย");
                }
            }, agenda
        );
        this.getSearchCalendar().destroy();
    },

    doSearch: function () {
        var store = this.getSearchCalendar().getStore();
        var value = this.getCalendarSearchField().getValue();
        if (value.trim() == "") {
            this.onClearSearchTap();
        }
        else {
            store.removeAll();
            this.getSearchCalendar().setMasked({
                xtype: 'loadmask',
                message: 'กำลังค้นหา..'
            });
            store.getProxy().setUrl(Mam.Util.getServerUrl() + "/service/getemployees/" + value);
            store.load(
                function (records, operation, success) {
                    if (records.length > 0) {
                        this.getSearchCalendar().refresh();
                    }
                    else {
                        this.getSearchCalendar().setEmptyText("ไม่พบพนักงาน");
                    }
                },
                this
            );
        }
    },

    onPushView: function (navView, pushView, eOpts) {
        if (pushView.id == "searchCalendar") {
        }
    },

    getAppointmentStore: function (vid) {
        var today = new Date();
        var month = this.leadingZero(today.getMonth() + 1);
        var year = this.leadingZero(today.getFullYear());
        var url = "";
        url = Mam.Util.getServerUrl() + "/service/viewappointments/"
            + vid + "/" + year + "/" + this.getMain().getUid()
            + "/excludemonth/" + month;
        var store = Ext.create('Mam.store.Appointments', {
            proxy: {
                type: 'jsonp',
                url: url,
                reader: {
                    type: 'json',
                    rootProperty: 'appointments'
                }
            }
        });
        return store;
    },

    leadingZero: function (value) {
        if (value < 10) {
            return "0" + value.toString();
        }
        return value.toString();
    },

    onViewMonthTap: function (button, e, eOpts) {
        this.setCurrentView("month");
    },

    onViewWeekTap: function (button, e, eOpts) {
        this.setCurrentView("week");
    },

    onViewDayTap: function (button, e, eOpts) {
        this.setCurrentView("day");
    },

    onViewAgendaTap: function (button, e, eOpts) {
        this.setCurrentView("agenda");
    },

    setCurrentView: function (view) {
        if (this.getMain().getActiveItem().getItemId() != "viewMainCalendar") {
            return;
        }
        this.getMain().getActiveItem().down("#viewAgenda").enable();
        this.getMain().getActiveItem().down("#viewWeek").enable();
        this.getMain().getActiveItem().down("#viewMonth").enable();
        this.getMain().getActiveItem().down("#viewDay").enable();
        if (view == "agenda") {
            this.getMain().getActiveItem().down("#viewAgenda").disable();
            this.getAgendaList().show();
            this.getMainCalendar().setActiveItem(this.getAgendaList());
        } else if (view == "month") {
            this.getMain().getActiveItem().down("#viewMonth").disable();
            this.getMainCalendar().setActiveItem(this.getEmployeeCalendar());
            this.getAgendaList().hide();
            this.getEmployeeCalendar().setViewMode("month");
        } else if (view == "week") {
            this.getMain().getActiveItem().down("#viewWeek").disable();
            this.getMainCalendar().setActiveItem(this.getEmployeeCalendar());
            this.getAgendaList().hide();
            this.getEmployeeCalendar().setViewMode("week");
        } else if (view == "day") {
            this.getMain().getActiveItem().down("#viewDay").disable();
            this.getMainCalendar().setActiveItem(this.getEmployeeCalendar());
            this.getAgendaList().hide();
            this.getEmployeeCalendar().setViewMode("day");
        }
    }
});