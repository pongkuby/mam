Ext.define('Mam.controller.Main', {
    extend: 'Ext.app.Controller',

    requires: [
        'Ext.ux.TouchCalendarEventsBase',
        'Ext.ux.TouchCalendarMonthEvents',
        'Ext.ux.TouchCalendarWeekEvents',
        'Ext.ux.TouchCalendarDayEvents',
        'Ext.ux.TouchCalendarEvents',
        'Ext.ux.TouchCalendarSimpleEvents',
        'Ext.ux.TouchCalendarView',
        'Ext.ux.TouchCalendar',
        'Mam.view.SearchCalendar',
        'Mam.view.SearchEmployee',
        'Mam.view.MainCalendar',
        'Mam.view.SearchAppointment',
        'Mam.view.Login',
        'Mam.store.LastLogin',
        'Ext.ux.Iframe',
        'Mam.Util',
        'Mam.view.AppointmentAlert',
        'Mam.view.ContactUs',
        'Mam.model.Problem'
    ],

    config: {
        refs: {
            main: 'main',
            mainCalendar: 'maincalendar',
            employeeCalendar: 'maincalendar #employeeCalendar',
            loginPanel: 'login',
            viewMonth: 'maincalendar #viewMonth',
            viewWeek: 'maincalendar #viewWeek',
            viewDay: 'maincalendar #viewDay',
            viewAgenda: 'maincalendar #viewAgenda',
            viewToday: 'maincalendar #viewToday',
            addButton: 'panel #addButton',
            agendaList: 'maincalendar #agendaList',
            searchCalendarButton: 'panel #searchCalendarButton',
            searchEmployeeButton: 'panel #searchEmployeeButton',
            searchCalendar: '#searchCalendar',
            searchEmployee: 'searchemployee',
            appointmentSearchField: 'toolbar #appointmentSearchField',
            searchAppointment: '#searchAppointment',
            homeButton: '#homeButton',
            logoutButton: 'panel #logoutButton',
            menuButton: 'main #menuButton',
            menuPanel: 'main #menuPanel',
            refreshButton: 'panel #refreshButton',
            userManualButton: 'panel #userManualButton',
            downloadPhoneBookButton: '#downloadPhoneBookButton',
            todayList: '#todayList',
            mwaAgendaButton: 'panel #mwaAgendaButton',
            showStatButton: 'panel #showStatButton',
            contactButton: 'panel #contactButton'
        },
        control: {
            calendar: {
                eventtap: 'onEventTap',
                periodchange: 'onPeriodchange',
                selectionchange: 'onSelectionchange'
            },
            main: {
                back: 'onNavigateBack',
                push: 'onPushView',
                initialize: 'onMainInitialize'
            },
            contactButton: {
                tap: 'onContactButtonTap'
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
            },
            viewToday: {
                tap: 'onViewTodayTap'
            },
            addButton: {
                tap: 'onAddButtonTap'
            },
            agendaList: {
                itemtap: 'onAgendaListTap'
            },
            searchCalendarButton: {
                tap: 'onSearchCalendarButtonTap'
            },
            searchEmployeeButton: {
                tap: 'onSearchEmployeeButtonTap'
            },
            appointmentSearchField: {
                focus: 'onAppointmentSearchFieldFocus'
            },
            homeButton: {
                tap: 'onHomeButtonTap'
            },
            logoutButton: {
                tap: 'onLogoutButtonTap'
            },
            menuButton: {
                tap: 'onMenuButtonTap'
            },
            refreshButton: {
                tap: 'onRefreshButtonTap'
            },
            userManualButton: {
                tap: 'onUserManualButtonTap'
            },
            mwaAgendaButton: {
                tap: 'onMwaAgendaButtonTap'
            },
            showStatButton: {
                tap: 'onViewStat'
            }
        },

        fullName: null,
        vid: null,
        offlineMode: false
    },

    launch: function (app) {
        var lastLogin = Ext.create("Mam.store.LastLogin");
        lastLogin.load(
            function (records, operation, success) {
                if (records.length > 0) {
                    var agenda = Ext.create('Ext.dataview.List', {
                        itemId: 'agendaList',
                        itemTpl: ['' +
                            '<div style="font-weight:bold ">{event}</div>',
                            '<div style="padding-top: 10px;">{title}</div>'
                        ],
                        grouped: true,
                        layout: 'fit',
                        hidden: true
                    });
                    if (Ext.os.is.Phone) {
                        var mainCal = Ext.create('Mam.view.phone.MainCalendar', {
                            title: records[0].get('fullName')
                        });
                    } else {
                        var mainCal = Ext.create('Mam.view.MainCalendar', {
                            title: records[0].get('fullName')
                        });
                    }
                    var lastView = records[0].get('lastView');
                    if (lastView == "agenda") {
                        agenda.setHidden(false);
                    }
                    mainCal.add(agenda);
                    var main = Ext.create("Mam.view.Main", {
                        uid: records[0].get('empId'),
                        currentView: lastView,
                        items: [
                            mainCal
                        ]
                    });
                    Ext.Viewport.add(main);
                    Mam.Util.writeLog(records[0].get('empId'), "Login.");
                }
                else {
                    Ext.Viewport.add(Ext.create('Mam.view.Login'));
                }
            }, this);
    },

    onMainInitialize: function (main, eOpts) {
        if (Ext.Object.fromQueryString(window.location.search).uid != null) {
            main.setUid(Ext.Object.fromQueryString(window.location.search).uid);
        }
        if (Ext.Object.fromQueryString(window.location.search).vid != null) {
            main.setVid(Ext.Object.fromQueryString(window.location.search).vid);
        }
        var calendarView;
        if (main.getCurrentView() == "agenda") {
            calendarView = "month";
        }
        else {
            calendarView = main.getCurrentView();
        }
        if (main.getUid() == "00101840" || main.getUid() == "00029025"
            || main.getUid() == "00068381" || main.getUid() == "00101567"
            || main.getUid() == "00101566") {
            main.down("panel #showStatButton").show();
        }
        var yearStore = this.getAppointmentStore();
        yearStore.load(function (records, operation, success) {
            var calendar = Ext.create('Ext.ux.TouchCalendar', {
                xtype: 'calendar',
                itemId: 'employeeCalendar',
                viewMode: calendarView,
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
            this.getMainCalendar().add(calendar);
            this.getMainCalendar().setActiveItem(calendar);
            this.setCurrentView(this.getMain().getCurrentView());
            this.getLogoutButton().show();
        }, this);
    },

    createCalendar: function (employeeFullname, calendarStore, agendaStore) {
        var calendar = Ext.create('Mam.view.MainCalendar', {
            calendarStore: calendarStore,
            agendaStore: agendaStore,
            title: "ตารางนัดหมายของ " + employeeFullname
        });
        return calendar;
    },

    /**
     * Handler for the SimpleCalendar's 'eventtap' event.
     * @method
     * @private
     * @param {TouchCalendar.model.Event} event The Event record that was tapped
     */
    onEventTap: function (event) {
        if (event.data.appType != 0) {
            window.location = Mam.Util.getServerUrl() + "/mam/view_meeting.php?aid="
                + event.data.appId + "&uid=" + this.getUid()
                + "&currentview=" + this.getMain().getCurrentView();
        }
    },

    /**
     * Handler for the SimpleCalendar's 'periodchange' event.
     * @method
     * @private
     * @param {Ext.ux.TouchCalendarView} view The underlying Ext.ux.TouchCalendarView instance
     * @param {Date} minDate The min date of the new period
     * @param {Date} maxDate The max date of the new period
     * @param {String} direction The direction the period change moved.
     */
    onPeriodchange: function (view, minDate, maxDate, direction, eOpts) {

    },

    /**
     * Handler for the SimpleCalendar's 'selectionchange' event.
     * @method
     * @private
     * @param {Ext.ux.TouchCalendarView} view The underlying Ext.ux.TouchCalendarView instance
     * @param {Date} newDate The new date that has been selected
     * @param {Date} oldDate The old date that was previously selected
     */
    onSelectionchange: function (cal, newDate, oldDate, eOpts) {
        var h = Math.ceil(Ext.Viewport.getWindowHeight() * 0.4),
            w = Math.ceil(Ext.Viewport.getWindowWidth() * 0.5);
        var todayList = Ext.create("Mam.view.DayList", {
            fullscreen: false,
            width: w,
            height: h,
            modal: true,
            hideOnMaskTap: true,
            currentDate: newDate,
            uid: this.getMain().getUid(),
            style: 'display: inline-block;font-size:14px',
            mainCurrentView: this.getMain().getCurrentView(),
            items: [
                {
                    xtype: 'toolbar',
                    docked: 'top',
                    title: newDate.toDateString(),
                    style: 'font-size:12px;'
                }
            ]
        });
        todayList.showBy(cal.getDateCell(newDate));
    },

    /**
     * Handler for the EventListPanel Calendar's 'selectionchange' event.
     * This is used to update the contents of the EventListPanel's list store's contents
     * with the events that fall on that day.
     * @method
     * @private
     * @param {Ext.ux.TouchCalendarView} view The underlying Ext.ux.TouchCalendarView instance
     * @param {Date} newDate The new date that has been selected
     * @param {Date} oldDate The old date that was previously selected
     */
    onEventListCalendarSelectionChange: function (view, newDate, oldDate) {
        var eventList = this.getEventList(),
            calendar = this.getEventListCalendar();

        // clear the filter on the EventStore so we're dealing with all the records
        calendar.eventStore.clearFilter();

        // filter the EventStore based on the selected date
        calendar.eventStore.filterBy(function (record) {
            var startDate = Ext.Date.clearTime(record.get('start'), true).getTime(),
                endDate = Ext.Date.clearTime(record.get('end'), true).getTime();

            return (startDate <= newDate) && (endDate >= newDate);
        }, this);

        // remove all the items from the EventList's store
        eventList.getStore().removeAll();

        // add the filtered records from the EventStore to the EventListStore
        eventList.getStore().setData(calendar.eventStore.getRange());
    },

    onNavigateBack: function (view, eOpts) {
        if (view.xtype == "main") {
            if (view.getActiveItem().xtype == "maincalendar") {
                this.getMenuButton().show();
                this.getAddButton().show();
                this.getSearchEmployeeButton().show();
                this.getSearchCalendarButton().show();
                this.getMenuButton().show();
                this.getDownloadPhoneBookButton().hide();
                this.setCurrentView(this.getMain().getCurrentView());
            }
        }
    },

    onPushView: function (main, pushView, eOpts) {
        if (pushView.xtype == "maincalendar" && pushView.itemId == "mainCalendar") {
            this.getMenuButton().show();
            this.getAddButton().show();
            this.getSearchEmployeeButton().show();
            this.getSearchCalendarButton().show();
            this.getMenuButton().show();
            this.checkAndUpdateView();
        }
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

    onViewTodayTap: function (button, e, eOpts) {
        button.disable();
        this.getViewWeek().enable();
        this.getViewMonth().enable();
        this.getViewAgenda().enable();
        this.getViewDay().enable();
        this.getMainCalendar().setValue(new Date());
        this.getAgendaList().hide();
        this.getMainCalendar().show();
        this.getMainCalendar().setActiveItem(this.getMainCalendar(), {type: 'slide', direction: 'left'});
    },

    setCurrentView: function (view) {
        if (this.getMain().getActiveItem().getItemId() != "mainCalendar") {
            return;
        }
        var lastLogin = Ext.getStore('lastLogin');
        if (lastLogin == null) {
            lastLogin = Ext.create("Mam.store.LastLogin");
        }
        lastLogin.load(
            function (records, operation, success) {
                if (records.length > 0) {
                    records[0].set('lastView', view);
                }
                lastLogin.sync();
            }, this
        );
        this.getViewAgenda().enable();
        this.getViewWeek().enable();
        this.getViewMonth().enable();
        this.getViewDay().enable();
        if (view == "agenda") {
            this.getViewAgenda().disable();
            this.getAgendaList().show();
            this.getMainCalendar().setActiveItem(this.getAgendaList());
            if (this.getAgendaList().getStore() == null) {
                this.loadAgenda();
            }
        } else if (view == "month") {
            this.getViewMonth().disable();
            this.getMainCalendar().setActiveItem(this.getEmployeeCalendar());
            this.getAgendaList().hide();
            this.getEmployeeCalendar().setViewMode("month");
        } else if (view == "week") {
            this.getViewWeek().disable();
            this.getMainCalendar().setActiveItem(this.getEmployeeCalendar());
            this.getAgendaList().hide();
            this.getEmployeeCalendar().setViewMode("week");
        } else if (view == "day") {
            this.getViewDay().disable();
            this.getMainCalendar().setActiveItem(this.getEmployeeCalendar());
            this.getAgendaList().hide();
            this.getEmployeeCalendar().setViewMode("day");
        }
    },

    onAddButtonTap: function (button, e, eOpts) {
        Mam.Util.writeLog(this.getUid(), "Add appointment.");
        var currentDate = this.getMainCalendar().value;
        window.location = Mam.Util.getServerUrl() + "/mam/add_meeting.php?uid="
            + this.getUid()
            + "&start_date=" + this.formattedDate(currentDate);
    },

    onAgendaListTap: function (list, index, target, record, e, eOpts) {
        if (record.get('appType') != 0) {
            window.location = Mam.Util.getServerUrl() + "/mam/view_meeting.php?aid="
                + record.get('appId') + "&uid=" + this.getUid()
                + "&currentview=" + this.getMain().getCurrentView();
        }
    },

    onSearchCalendarButtonTap: function (button, e, eOpts) {
        Mam.Util.writeLog(this.getUid(), "Search Calendar.");
        this.getSearchCalendarButton().hide();
        this.getAddButton().hide();
        this.getMenuButton().hide();
        this.getMenuPanel().hide();
        this.getMain().push(Ext.create('Mam.view.SearchCalendar', {
            uid: this.getUid()
        }));
        var textField = Ext.ComponentQuery.query("#calendarSearchField")[0];
        textField.focus('', 30);
    },

    onSearchEmployeeButtonTap: function (button, e, eOpts) {
        this.getSearchEmployeeButton().hide();
        this.getAddButton().hide();
        this.getSearchCalendarButton().hide();
        this.getMenuButton().hide();
        this.getDownloadPhoneBookButton().show();
        this.getMenuPanel().hide();
        Mam.Util.writeLog(this.getUid(), "Search telephone.");
        if (!this.getSearchEmployee()) {
            Ext.os.is.Phone ?
                Ext.create('Mam.view.phone.SearchEmployee') :
                Ext.create('Mam.view.SearchEmployee');
        }
        this.getMain().push(this.getSearchEmployee());
    },

    onAppointmentSearchFieldFocus: function (searchfield, e, eOpts) {
        this.getAddButton().hide();
        this.getMenuButton().hide();
        this.getSearchEmployeeButton().hide();
        this.getSearchCalendarButton().hide();
        if (this.getSearchAppointment() != null) {
            this.getSearchAppointment().setOfflineMode(this.getOfflineMode());
            this.getMain().push(this.getSearchAppointment());
        }
        else {
            var item;
            if (Ext.os.is.Phone) {
                item = Ext.create('Mam.view.phone.SearchAppointment');
            }
            else {
                item = Ext.create('Mam.view.SearchAppointment');
            }
            item.setOfflineMode(this.getOfflineMode());
            this.getMain().push(item);
        }
        Ext.getCmp('appointmentSearchField').focus('', 20);
    },

    leadingZero: function (value) {
        if (value < 10) {
            return "0" + value.toString();
        }
        return value.toString();
    },

    onHomeButtonTap: function () {
        window.location.search = Ext.Object.toQueryString({
            uid: this.getUid()
        });
        this.getHomeButton().hide();
    },

    formattedDate: function (date) {
        return Mam.Util.formatDate(date);
    },

    dateCompare: function (DateA, DateB) {
        var a = new Date(DateA);
        var b = new Date(DateB);
        var msDateA = Date.UTC(a.getFullYear(), a.getMonth() + 1, a.getDate());
        var msDateB = Date.UTC(b.getFullYear(), b.getMonth() + 1, b.getDate());
        if (parseFloat(msDateA) < parseFloat(msDateB))
            return -1;  // lt
        else if (parseFloat(msDateA) == parseFloat(msDateB))
            return 0;  // eq
        else if (parseFloat(msDateA) > parseFloat(msDateB))
            return 1;  // gt
        else
            return null;  // error
    },

    onLogoutButtonTap: function (button) {
        Mam.Util.writeLog(this.getMain().getUid(), "Logout.");
        var store = Ext.getStore('lastLogin');
        store.load(
            function (records, operation, success) {
                if (records.length > 0) {
                    store.removeAll();
                    store.sync();
                    this.getLogoutButton().hide();
                    this.getMenuPanel().hide();
                    Ext.Viewport.remove(this.getMain(), true);
                    var login = Ext.Viewport.add(Ext.create('Mam.view.Login'));
                    Ext.Viewport.add(login);
                    var textField = Ext.ComponentQuery.query("#usernameTextField")[0];
                    textField.focus('', 30);
                }
            }, this
        );
    },

    onMenuButtonTap: function (button) {
        this.getMenuPanel().showBy(button);
    },

    onRefreshButtonTap: function (button) {
        location.reload();
    },

    onUserManualButtonTap: function (button) {
        this.getMenuPanel().hide();
        this.getMenuButton().hide();
        this.getAddButton().hide();
        Mam.Util.writeLog(this.getUid(), "View manual.");
        this.getMain().push(
            Ext.create("Ext.ux.Iframe", {
                    title: 'คู่มือการใช้งานระบบ M@M',
                    href: Mam.Util.getServerUrl() + "/manual"}
            ));
    },

    checkAndUpdateView: function () {
        if (this.getMain().getCurrentView() == 'month') {
            this.onViewMonthTap();
        } else if (this.getMain().getCurrentView() == 'week') {
            this.onViewWeekTap();
        }
        else if (this.getMain().getCurrentView() == 'day') {
            this.onViewDayTap();
        }
        else if (this.getMain().getCurrentView() == 'agenda') {
            this.onViewAgendaTap();
        }
    },

    /**
     * Check และแสดงการแจ้งเตือนตารางนัดหมาย
     * */
    getAppointmentAlert: function () {
        var alert = Ext.create("Mam.view.AppointmentAlert", {
            uid: this.getUid(),
            left: 300,
            mainCurrentView: this.getMain().getCurrentView(),
            main: this.getMenuButton(),
            items: [
                {
                    xtype: 'toolbar',
                    docked: 'top',
                    title: 'แจ้งเตือนตารางนัดหมาย (' + new Date().toDateString() + ')',
                    style: 'font-size:12px;'
                },
                {
                    docked: 'bottom',
                    xtype: 'toolbar',
                    defaults: {
                        flex: 1
                    },
                    items: [
                        {
                            xtype: 'selectfield',
                            id: 'alertOption',
                            padding: '7px',
                            options: [
                                {text: 'ไม่ต้องแจ้งเตือนซ้ำ', value: '1'},
                                {text: 'แจ้งเตือนซ้ำ', value: '2'}
                            ]
                        },
                        {
                            xtype: 'button',
                            id: 'closeAlertButton',
                            ui: 'round',
                            padding: '10px',
                            text: 'ตกลง'
                        }
                    ]
                }
            ]
        });
    },

    getAppointmentStore: function () {
        var today = new Date();
        var month = this.leadingZero(today.getMonth() + 1);
        var year = this.leadingZero(today.getFullYear());
        var url = "";
        if (this.getMain().getVid() != null) {
            url = Mam.Util.getServerUrl() + "/service/viewappointments/"
                + this.getMain().getVid() + "/" + year + "/" + this.getMain().getUid()
                + "/excludemonth/" + month;
        }
        else {
            url = Mam.Util.getServerUrl() + "/service/getappointments/"
                + this.getMain().getUid() + "/" + year + "/excludemonth/" + month;
        }
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

    /**
     * ดึง ID ของ Employee
     * @return {integer} ID
     * */
    getUid: function () {
        return this.getMain().getUid();
    },

    /**
     * ดึง ID ของ Employee ที่กำลังดูปฏิทิน
     * @return {integer} ID
     * */
    getVid: function () {
        return this.getMain().getVid();
    },

    onMwaAgendaButtonTap: function (button) {
        Mam.Util.writeLog(this.getMain().getUid(), "View mwa agenda.");
        this.getAddButton().hide();
        this.getMenuButton().hide();
        this.getMenuPanel().hide();
        var list = Ext.create("Mam.view.BookingList");
        this.getMain().push(list);
    },

    loadAgenda: function () {
        var agendaStore = this.getAppointmentStore();
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
        this.getAgendaList().setMasked({
            xtype: 'loadmask',
            message: 'Loading..'
        });
        this.getAgendaList().setStore(agendaStore);
        agendaStore.load(
            function (records, operation, success) {
                if (records.count > 0) {
                    this.getAgendaList().refresh();
                }
                else {
                    this.getAgendaList().setEmptyText("ไม่พบตารางนัดหมาย");
                }
            }, this
        );
    },

    onViewStat: function () {
        Mam.Util.writeLog(this.getUid(), "View stat.");
        this.getMenuPanel().hide();
        this.getMenuButton().hide();
        this.getAddButton().hide();
        this.getApplication().getController('Mam.controller.Stats').viewStat();
    },

    onContactButtonTap: function (button) {
        Mam.Util.writeLog(this.getUid(), "View contact us.");
        window.location.href = "#contactus";
        this.getMenuPanel().hide();
    }
});

