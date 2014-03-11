Ext.define('Mam.model.Login', {
    extend: 'Ext.data.Model',

    config: {
        fields: [
            { name: 'statusLogin', type: 'string' }
            
        ],
        validations: [
            { type: 'presence', field: 'statusLogin' }
        ]
    }
});