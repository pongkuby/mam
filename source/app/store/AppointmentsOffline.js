/**
 * Created with JetBrains PhpStorm.
 * User: Thammarak
 * Date: 24/6/2556
 * Time: 13:44 น.
 */
Ext.define('Mam.store.AppointmentsOffline', {
    extend: 'Ext.data.Store',
    requires: [
        'Mam.model.Appointment',
        'Ext.data.proxy.LocalStorage'
    ],
    config: {
        identifier: 'uuid',
        storeId: 'appointmentsOffline',
        model: 'Mam.model.Appointment',
        autoLoad: true,
        groupDir: 'ASC',
        grouper: {
            sortProperty: 'start',
            groupFn: function (record) {
                if (record.get('start') != null) {
                    return record.get('start').toDateString();
                }
            }},
        sorters: 'start',
        proxy: {
            type: 'localstorage',
            id: 'appointmentsOffline'
        }
    }
});
