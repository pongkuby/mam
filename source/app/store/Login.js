/**
 * User: Thammarak
 * Date: 20/5/2556
 * Time: 15:32 น.
 */
Ext.define('Mam.store.Login', {
    extend: 'Ext.data.Store',
    requires: [
        'Mam.model.Employee',
        'Ext.data.proxy.JsonP'
    ],
    config: {
        model: 'Mam.model.Employee',
        autoLoad: false
    }
});
