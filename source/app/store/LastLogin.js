/**
 * Created by pongkuby.
 * Date: 26/6/2556
 * Time: 23:06 น.
 */
Ext.define('Mam.store.LastLogin', {
    extend: 'Ext.data.Store',
    requires: [
        'Mam.model.LastLogin',
        'Ext.data.proxy.LocalStorage'
    ],
    config: {
        identifier: 'uuid',
        model: 'Mam.model.LastLogin',
        storeId: 'lastLogin',
        autoLoad: true,
        proxy: {
            type: 'localstorage',
            id: 'lastLogin'
        }
    }
});
