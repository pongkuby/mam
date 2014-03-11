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
        proxy: {
            type: 'rest',
            api: {
                create: Mam.Util.getServerUrl() + '/service/problem/create',
                read: Mam.Util.getServerUrl() + '/service/problem/fetch',
                update: Mam.Util.getServerUrl() + '/service/problem/update',
                destroy: Mam.Util.getServerUrl() + '/service/problem/delete'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        }
    }
});