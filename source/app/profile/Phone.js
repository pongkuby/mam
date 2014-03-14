/**
 * Created by Thammarak.
 * Date: 12/6/2556
 * Time: 7:29 น.
 */
Ext.define('Mam.profile.Phone', {
    extend: 'Ext.app.Profile',

    config: {
        controllers: [
            'Mam.controller.phone.Main',
            'Mam.controller.Login',
            'Mam.controller.SearchCalendar',
            'Mam.controller.SearchEmployee',
            'Mam.controller.SearchAppointment',
            'Mam.controller.DayList',
            'Mam.controller.Booking',
            'Mam.controller.AppointmentAlert',
            'Mam.controller.Stats',
            'Mam.controller.Problem',
            'Mam.controller.ContactUs',
            'Mam.controller.Appointment'
        ],
        views:[
            'Mam.view.phone.Main',
            'Mam.view.phone.MainCalendar'
        ]
    },

    isActive: function () {
        return Ext.os.is.Phone;
    },

    launch: function () {
    }
});
