/**
 * User: Thammarak
 * Date: 20/5/2556
 * Time: 15:32 น.
 */
Ext.define('Mam.store.Appointments', {
    extend: 'Ext.data.Store',
    requires: [
        'Mam.model.Appointment',
        'Ext.data.proxy.JsonP'
    ],
    config: {
        storeId: 'appointmentStore',
        model: 'Mam.model.Appointment',
        autoLoad: false,
        groupDir: 'ASC',
        grouper: {
            sortProperty: 'start',
            groupFn: function (record) {
                if (record.get('start') != null) {
                    return record.get('start').toDateString();
                }
            }},
        sorters: 'start'
    }
});
