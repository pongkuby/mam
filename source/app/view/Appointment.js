Ext.define('Mam.view.Appointment', {
    extend: 'Ext.form.Panel',
    xtype: 'appointment',
    requires: [
        'Ext.field.*',
        'Ext.ux.field.TimePicker',
        'Mam.store.Employees',
        'Ext.form.*'
    ],
    id: 'appointmentForm',
    url: 'service/postappointment',
    config: {
        title: 'Appointment',
        /*Add , Edit*/
        mode: 'Add',
        items: [
            {
                xtype: 'fieldset',
                defaults: {
                    labelWidth: '35%'
                },
                items: [
                    {
                        name: 'title',
                        xtype: 'textfield',
                        label: 'Title',
                        placeHolder: 'หัวข้อการนัดหมาย',
                        autoCapitalize: true,
                        required: true,
                        clearIcon: true,
                        id: 'title'
                    },
                    {
                        xtype: 'selectfield',
                        name: 'appType',
                        label: 'Type',
                        options: [
                            {
                                text: 'ประชุม',
                                value: 1
                            },
                            {
                                text: 'สัมมนา',
                                value: 2
                            },
                            {
                                text: 'ฟังบรรยาย',
                                value: 3
                            }
                        ]
                    }

                ]},
            {
                xtype: 'fieldset',
                defaults: {
                    labelWidth: '35%'
                },
                items: [
                    {
                        xtype: 'container',
                        layout: {
                            type: 'hbox',
                            clearIcon: true
                        },
                        items: [
                            {
                                xtype: 'container',
                                flex: 1,
                                defaults: {
                                    labelWidth: '70%'
                                },
                                items: [
                                    {
                                        id:'start',
                                        name: 'start',
                                        xtype: 'datepickerfield',
                                        format: 'd m Y',
                                        value: new Date(),
                                        label: 'Start'
                                    }
                                ]
                            },
                            {
                                xtype: 'container',
                                flex: 1,
                                items: [
                                    {
                                        name: 'startTime',
                                        id: 'startTime',
                                        xtype: 'timepickerfield',
                                        value: new Date(),
                                        label: 'Time'
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        xtype: 'container',
                        layout: {
                            type: 'hbox',
                            fullscreen: true
                        },
                        items: [
                            {
                                xtype: 'container',
                                flex: 1,
                                defaults: {
                                    labelWidth: '70%'
                                },
                                items: [
                                    {
                                        name: 'end',
                                        id: 'end',
                                        xtype: 'datepickerfield',
                                        format: 'd m Y',
                                        value: new Date(),
                                        label: 'End'
                                    }
                                ]
                            },
                            {
                                xtype: 'container',
                                flex: 1,
                                items: [
                                    {
                                        name: 'endTime',
                                        id: 'endTime',
                                        xtype: 'timepickerfield',
                                        value: new Date(),
                                        label: 'Time'
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        xtype: 'togglefield',
                        name: 'isAllDay',
                        id: 'isAllDay',
                        label: 'All Day'
                    }
                ]
            },

            {
                xtype: 'fieldset',
                defaults: {
                    labelWidth: '35%'
                },
                items: [
                    {
                        name: 'place',
                        xtype: 'textfield',
                        label: 'Place',
                        placeHolder: 'สถานที่',
                        required: true
                    },
                    {
                        name: 'detail',
                        xtype: 'textareafield',
                        placeHolder: 'รายละเอียด',
                        label: 'Detail'
                    }
                ]
            }
        ]
    }
});
