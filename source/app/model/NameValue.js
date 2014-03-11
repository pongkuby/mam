/**
 * Created by Thammarak on 15/2/2557.
 */
Ext.define('Mam.model.NameValue', {
    extend: 'Ext.data.Model',

    config: {
        identifier: 'uuid',
        fields: [
            { name: 'name', type: 'string' },
            { name: 'value' }
        ]
    }
});