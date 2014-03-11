/**
 * Created by Thammarak.
 * Date: 13/6/2556
 * Time: 7:48 น.
 */
Ext.define('Mam.profile.Tablet', {
    extend: 'Ext.app.Profile',

    config: {
        controllers: [
            'Mam.controller.Main',
            'Mam.controller.Login',
            'Mam.controller.SearchCalendar',
            'Mam.controller.SearchEmployee',
            'Mam.controller.SearchAppointment',
            'Mam.controller.DayList',
            'Mam.controller.Booking',
            'Mam.controller.AppointmentAlert',
            'Mam.controller.Stats',
            'Mam.controller.Problem',
            'Mam.controller.ContactUs'
        ],
        views: [
            'Mam.view.Main',
            'Mam.view.MainCalendar'
        ]
    },

    isActive: function () {
        return Ext.os.is.Tablet || Ext.os.is.Desktop || Ext.os.is.iPad;
    },

    launch: function () {
    }
});
