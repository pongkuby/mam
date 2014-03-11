Ext.define('Mam.model.Employee', {
    extend: 'Ext.data.Model',

    config: {
        identifier:'uuid',
        fields: [
            { name: 'empId', type: 'string' },
            { name: 'firstName', type: 'string' },
            { name: 'lastName', type: 'string' },
            { name: 'email', type: 'string' },
            { name: 'mobilePhone', type: 'string' },
            { name: 'phone', type: 'string' },
            { name: 'phoneOnly', type: 'string' },
            { name: 'division', type: 'string' },
            { name: 'sub_group', type: 'string' },
            { name: 'ee_group', type: 'string' },
            { name: 'position', type: 'string' }
        ],
        validations: [
            { type: 'presence', field: 'empId' }
        ]
    },

    getFullName: function () {
        return this.data.firstName + " " + this.data.lastName;
    }
});