Ext.define('Mam.controller.phone.Main', {
    extend: 'Mam.controller.Main',

    requires: [
        'Mam.view.phone.MainCalendar'
    ],

    config: {
        refs: {
            main: 'main',
            mainCalendar: 'maincalendar',
            employeeCalendar: 'maincalendar #employeeCalendar',
            loginPanel: 'login',
            viewMonth: 'panel #viewMonth',
            viewWeek: 'panel #viewWeek',
            viewDay: 'panel #viewDay',
            viewAgenda: 'panel #viewAgenda',
            viewToday: 'maincalendar #viewToday',
            addButton: 'panel #addButton',
            agendaList: 'maincalendar #agendaList',
            searchCalendarButton: 'panel #searchCalendarButton',
            searchEmployeeButton: 'panel #searchEmployeeButton',
            searchCalendar: '#searchCalendar',
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
            contactButton: 'panel #contactButton',
            mwaAgendaButton: 'panel #mwaAgendaButton',
            viewList: 'toolbar #viewList',
            viewButton: 'toolbar #viewButton'
        },
        control: {
            homeButton: {
                tap: 'onHomeButtonTap'
            },
            viewButton: {
                tap: 'onViewButtonTap'
            },
            menuList: {
                tap: 'onMenuListTap'
            },
            viewMonth: {
                tap: 'onViewMonthTap'
            },
            viewWeek: {
                tap: 'onViewWeekTap'
            },
            searchEmployeeButton: {
                tap: 'onSearchEmployeeButtonTap'
            },
            searchCalendarButton: {
                tap: 'onSearchCalendarButtonTap'
            },
            logoutButton: {
                tap: 'onLogoutButtonTap'
            },
            main: {
                back: 'onNavigateBack',
                push: 'onPushView',
                initialize: 'onInitialize'
            },
            appointmentSearchField: {
                focus: 'onAppointmentSearchFieldFocus'
            }
        }
    },

    launch: function (app) {
        this.callParent();
    },

    onInitialize: function (main, eOpts) {
        this.getMenuButton().setText("");
        this.getViewButton().setText(main.getCurrentView());
        this.onMainInitialize(main, eOpts);
    },

    onViewButtonTap: function (button, e, eOpts) {
        this.getViewList().showBy(button);
    },

    onMenuListTap: function (button, e, eOpts) {
        this.getMenuPanel().showBy(button);
    },

    onSearchEmployeeButtonTap: function (button, e, eOpts) {
        this.getMenuPanel().hide();
        this.getDownloadPhoneBookButton().setText("");
        this.callParent([button, e, eOpts]);
    },

    onSearchCalendarButtonTap: function (button, e, eOpts) {
        this.getMenuPanel().hide();
        this.callParent([button]);
    },

    onLogoutButtonTap: function (button) {
        this.getMenuPanel().hide();
        this.callParent([button]);
    },

    onNavigateBack: function (view, eOpts) {
        this.callParent([view, eOpts]);
    },

    onViewWeekTap: function (button, e, eOpts) {
        this.getViewButton().setText('Week');
        this.getViewList().hide();
        this.setCurrentView("week");
    },

    onViewDayTap: function (button, e, eOpts) {
        this.getViewButton().setText('Day');
        this.getViewList().hide();
        this.callParent();
    },

    onViewMonthTap: function (button, e, eOpts) {
        this.getViewButton().setText('Month');
        this.getViewList().hide();
        this.callParent();
    },

    onViewAgendaTap: function (button, e, eOpts) {
        this.getViewButton().setText('Agenda');
        this.getViewList().hide();
        this.callParent();
    },

    onAppointmentSearchFieldFocus: function (searchfield, e, eOpts) {
        this.callParent([searchfield, e, eOpts]);
    }
});
