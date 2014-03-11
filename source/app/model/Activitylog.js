/**
 * ใช้เก็บตารางจองห้องประชุม
 * Created by Thammarak.
 * Date: 31/1/2557
 * Time: 7:49 น.
 */
Ext.define('Mam.model.Activitylog', {
    extend: 'Ext.data.Model',

    config: {
        identifier: 'uuid',
        fields: [
            { name: 'emp_id', type: 'string' },
            { name: 'first_name', type: 'string' },
            { name: 'last_name', type: 'string'},
            { name: 'ipaddress', type: 'string'},
            { name: 'activity_time', type: 'date' },
            { name: 'activity_text', type: 'string' }
        ]
    }
});