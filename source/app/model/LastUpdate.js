/**
 * Created by Thammarak.
 * Date: 28/6/2556
 * Time: 15:49 น.
 */

Ext.define('Mam.model.LastUpdate', {
    extend: 'Ext.data.Model',

    config: {
        fields: [
            { name: 'empId', type: 'int' },
            { name: 'modifiedDate', type: 'date' }
        ],

        proxy: {
            type: 'rest',
            url: 'service/getlastmodifieddate',
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        }
    }
});