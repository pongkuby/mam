/**
 * User: Thammarak
 * Date: 20/5/2556
 * Time: 15:32 น.
 */
Ext.define('Mam.store.Problems', {
    extend: 'Ext.data.Store',
    requires: [
        'Mam.model.Problem',
        'Ext.data.proxy.JsonP',
        'Mam.Util'
    ],
    config: {
        model: 'Mam.model.Problem',
        autoLoad: true,
        proxy: {
            type: 'rest',
            url: Mam.Util.getServerUrl() + '/service/problems/load',
            reader: {
                rootProperty: 'data'
            }
        }
    }
});
