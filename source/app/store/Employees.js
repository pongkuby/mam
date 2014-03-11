/**
 * User: Thammarak
 * Date: 20/5/2556
 * Time: 15:32 น.
 */
Ext.define('Mam.store.Employees', {
    extend: 'Ext.data.Store',
    requires: [
        'Mam.model.Employee',
        'Ext.data.proxy.JsonP',
        'Mam.Util'
    ],
    config: {
        model: 'Mam.model.Employee',
        autoLoad: false,
        proxy: {
            type: 'jsonp',
            url: Mam.Util.getServerUrl() + '/service/getallemployee',
            reader: {
                type: 'json',
                rootProperty: 'employees'
            }
        }
    }
});
