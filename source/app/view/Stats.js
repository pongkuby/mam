/**
 * เป็น View ที่ใช้แสดง Stats ของ M@M
 * Created by Thammarak on 15/2/2557.
 * Date Format -> https://code.google.com/p/datejs/wiki/FormatSpecifiers
 */
Ext.define('Mam.view.Stats', {
    extend: 'Ext.Container',
    xtype: 'stats',
    requires: [
        'Ext.chart.series.Pie',
        'Ext.chart.PolarChart',
        'Ext.chart.interactions.Rotate',
        'Ext.chart.CartesianChart',
        'Ext.chart.axis.Numeric',
        'Ext.chart.axis.Category',
        'Ext.chart.series.Line',
        'Ext.chart.interactions.ItemInfo'
    ],
    config: {
        title: 'สถิติการใช้งานระบบ M@M',
        layout: 'hbox',
        currentChart:"",
        items: [
            {
                xtype: 'container',
                itemId: 'optionPanel',
                width: '15%',
                flex: 1,
                layout: 'vbox',
                items: [
                    {
                        xtype: 'datepickerfield',
                        label: 'From',
                        name: 'fromDate',
                        itemId: 'fromDate',
                        value: new Date(),
                        dateFormat: 'd-M-y'
                    },
                    {
                        xtype: 'datepickerfield',
                        label: 'To',
                        name: 'toDate',
                        itemId: 'toDate',
                        value: new Date(),
                        dateFormat: 'd-M-y'
                    },
                    {
                        xtype: 'list',
                        itemId: 'chartSelector',
                        itemTpl: '{title}',
                        flex: 2,
                        listeners: {
                            painted: function (element) {
                                Ext.getCmp(element.getId()).select(1);
                            }
                        },
                        store: {
                            data: [
                                {
                                    id: "list",
                                    title: 'สถิติผู้ใช้งาน'
                                },
                                {
                                    id: "os",
                                    title: 'สถิติตาม ระบบปฏิบัติการ'
                                },
                                {
                                    id: "browser",
                                    title: 'สถิติตาม Browser'
                                },
                                {
                                    id: "monthly",
                                    title: 'สถิติผู้ใช้งาน รายเดือน'
                                }
                            ]
                        }
                    }
                ]
            },
            {
                xtype: 'container',
                itemId: 'chartContainer',
                flex: 3,
                layout: 'card',
                items: [
                    {
                        xtype: 'polar',
                        itemId: 'pieChart',
                        animate: true,
                        interactions: ['rotate'],
                        colors: ['#115fa6', '#94ae0a', '#a61120', '#ff8809', '#ffd13e'],
                        store: {
                            fields: ['name', 'data1', 'data2', 'data3', 'data4', 'data5'],
                            data: [
                                {name: 'metric one', data1: 10, data2: 12, data3: 14, data4: 8, data5: 13},
                                {name: 'metric two', data1: 7, data2: 8, data3: 16, data4: 10, data5: 3},
                                {name: 'metric three', data1: 5, data2: 2, data3: 14, data4: 12, data5: 7},
                                {name: 'metric four', data1: 2, data2: 14, data3: 6, data4: 1, data5: 23},
                                {name: 'metric five', data1: 27, data2: 38, data3: 36, data4: 13, data5: 33}
                            ]
                        },
                        series: [
                            {
                                type: 'pie',
                                itemId: 'pieSeries',
                                label: {
                                    field: 'name',
                                    display: 'rotate'
                                },
                                xField: 'value',
                                donut: 30
                            }
                        ]
                    },
                    {
                        xtype: 'chart',
                        itemId: 'lineChart',
                        interactions: [
                            {
                                type: 'iteminfo',
                                gesture: 'taphold',
                                listeners: {
                                    show: function (interaction, item, panel) {
                                        var record = item.storeItem;
                                        panel.update(
                                            '<b>Traffic in ' + item.get('name') + ':</b>' + item.get('value')
                                        );
                                    }
                                }
                            }
                        ],
                        animate: true,
                        store: {
                            fields: ['name', 'data1', 'data2', 'data3', 'data4', 'data5'],
                            data: [
                                {'name': 'metric one', 'data1': 10, 'data2': 12, 'data3': 14, 'data4': 8, 'data5': 13},
                                {'name': 'metric two', 'data1': 7, 'data2': 8, 'data3': 16, 'data4': 10, 'data5': 3},
                                {'name': 'metric three', 'data1': 5, 'data2': 2, 'data3': 14, 'data4': 12, 'data5': 7},
                                {'name': 'metric four', 'data1': 2, 'data2': 14, 'data3': 6, 'data4': 1, 'data5': 23},
                                {'name': 'metric five', 'data1': 27, 'data2': 38, 'data3': 36, 'data4': 13, 'data5': 33}
                            ]
                        },
                        axes: [
                            {
                                type: 'numeric',
                                position: 'left',
                                fields: ['value'],
                                title: {
                                    text: 'Sample Values',
                                    fontSize: 15
                                },
                                grid: true,
                                minimum: 0
                            },
                            {
                                type: 'category',
                                position: 'bottom',
                                fields: ['name'],
                                title: {
                                    text: 'Sample Values',
                                    fontSize: 15
                                }
                            }
                        ],
                        series: [
                            {
                                type: 'line',
                                highlight: {
                                    size: 7,
                                    radius: 7
                                },
                                style: {
                                    stroke: 'rgb(143,203,203)'
                                },
                                fill: true,
                                xField: 'name',
                                yField: 'value',
                                label: { display: 'inside', field: 'value'},
                                marker: {
                                    type: 'path',
                                    path: ['M', -2, 0, 0, 2, 2, 0, 0, -2, 'Z'],
                                    stroke: 'green',
                                    lineWidth: 5
                                }
                            }

                        ]
                    },
                    {
                        xtype: 'list',
                        itemId: 'statList',
                        itemTpl: [
                            '<div style="font-weight: bold;">{activity_time:date("F j, Y H:i:s")}</div>',
                            '<div style="margin-left: 5px;"><B>IP:</B> {ipaddress}</div>',
                            '<div style="margin-left: 5px;"><B>พนักงาน:</B> {first_name} {last_name} ({emp_id})</div>',
                            '<div style="margin-left: 5px;"><B>กิจกรรม:</B> {activity_text}</div>'
                        ]
                    }
                ]
            }
        ]
    }
});