/**
 * Created by Thammarak.
 * Date: 21/6/2556
 * Time: 9:37 น.
 */
Ext.define('Mam.model.LastLogin', {
    extend: 'Ext.data.Model',

    config: {
        identifier: 'uuid',
        fields: [
            { name: 'empId', type: 'string' },
            { name: 'fullName', type: 'string' },
            { name: 'lastView', type: 'string' }
        ]
    }
});