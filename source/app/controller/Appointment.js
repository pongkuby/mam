Ext.define('Mam.controller.Appointment', {
    extend: 'Ext.app.Controller',

    requires: [
        'Mam.store.Appointments',
        'Mam.view.Appointment'
    ],

    config: {
        refs: {
            appointment: 'appointment'
        },
        routes: {
            'viewappointment/:appid': 'viewAppointment'
        }
    },

    viewAppointment:function(appid){
        Ext.create("Mam.view.Appointment");
        Ext.Viewport.add(this.getAppointment());
        Ext.Viewport.setActiveItem(this.getAppointment());
    }
});