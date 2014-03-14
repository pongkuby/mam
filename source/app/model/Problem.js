/**
 * ใช้ปัญหาที่มีการแจ้ง
 * Created by Thammarak.
 * Date: 31/1/2557
 * Time: 7:49 น.
 */
Ext.define('Mam.model.Problem', {
    extend: 'Ext.data.Model',

    requires: [
        'Mam.Util',
        'Ext.data.proxy.Rest'
    ],

    config: {
        identifier: 'uuid',
        idProperty: 'problemId',
        fields: [
            { name: 'problemId', type: 'integer' },
            { name: 'empId', type: 'string' },
            { name: 'fullName', type: 'string' },
            { name: 'title', type: 'string'},
            { name: 'postDate', type: 'date' },
            { name: 'detail', type: 'string' }
        ],
        validations: [
            { type: 'presence', field: 'title' },
            { type: 'presence', field: 'detail' }
        ],
        proxy: {
            type: 'rest',
            api: {
                create: '/service/problem/create',
                read: '/service/problem/fetch',
                update: '/service/problem/update',
                destroy: '/service/problem/delete'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        }
    }
});