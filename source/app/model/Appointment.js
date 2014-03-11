Ext.define('Mam.model.Appointment', {
    extend: 'Ext.data.Model',

    config: {
        identifier: 'uuid',
        fields: [
            { name: 'appId', type: 'integer' },
            { name: 'appType', type: 'integer' },
            { name: 'event', type: 'string'},
            { name: 'title', type: 'string' },
            { name: 'place', type: 'string' },
            { name: 'detail', type: 'string' },
            { name: 'isAllDay', type: 'boolean' },
            { name: 'start', type: 'date' },
            { name: 'end', type: 'date' },
            { name: 'css', type: 'string', defaultValue: 'normal'},
            { name: 'weight', type: 'float'},
            { name: 'wasteWeight', type: 'float'},
            { name: 'startTime', type: 'string' },
            { name: 'endTime', type: 'string' }
        ]
    }
});