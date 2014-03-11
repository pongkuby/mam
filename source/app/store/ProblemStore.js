/**
 * User: Thammarak
 * Date: 20/5/2556
 * Time: 15:32 น.
 */
Ext.define('Mam.store.ProblemStore', {
    extend: 'Ext.data.Store',
    requires: [
        'Mam.model.Problems',
        'Ext.data.proxy.JsonP',
        'Mam.Util'
    ],
    config: {
        model: 'Mam.model.Problem',
        autoLoad: true
    },
    proxy: {
        type: 'rest',
        url: Mam.Util.getServerUrl() + '/service/problems/load',
        reader: {
            rootProperty: 'data'
        }
    }
});
