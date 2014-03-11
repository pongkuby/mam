/**
 * ใช้เก็บตารางจองห้องประชุม
 * Created by Thammarak.
 * Date: 31/1/2557
 * Time: 7:49 น.
 */
Ext.define('Mam.model.Booking', {
    extend: 'Ext.data.Model',

    config: {
        identifier: 'uuid',
        idProperty: 'bookId',
        fields: [
            { name: 'bookId', type: 'integer' },
            { name: 'subject', type: 'string' },
            { name: 'bookDate', type: 'date'},
            { name: 'startTime', type: 'string' },
            { name: 'endTime', type: 'string' },
            { name: 'room', type: 'string' },
            { name: 'bookBy', type: 'string' },
            { name: 'totalPeople', type: 'integer' }
        ]
    }
});