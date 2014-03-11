/**
 * TouchCalendar.view.MainTabPanel
 */
Ext.define('Mam.view.MainCalendar', {
    extend: 'Ext.Panel',
    xtype: 'maincalendar',
    requires: [
        'Ext.ux.TouchCalendarEventsBase',
        'Ext.ux.TouchCalendarMonthEvents',
        'Ext.ux.TouchCalendarWeekEvents',
        'Ext.ux.TouchCalendarDayEvents',
        'Ext.ux.TouchCalendarEvents',
        'Ext.ux.TouchCalendarSimpleEvents',
        'Ext.ux.TouchCalendarView',
        'Ext.ux.TouchCalendar',
        'Ext.dataview.List'
    ],

    config: {
        itemId : 'mainCalendar',
        fullscreen: true,
        layout: 'card',
        agendaStore: null,
        currentView: 'month',
        items:[
            {
                xtype: 'toolbar',
                docked: 'top',
                items: [
                    {
                        itemId : 'viewMonth',
                        xtype: 'button',
                        text: 'Month',
                        disabled: true
                    },
                    {
                        itemId : 'viewWeek',
                        xtype: 'button',
                        text: 'Week'
                    },
                    {
                        itemId : 'viewDay',
                        xtype: 'button',
                        text: 'Day'
                    },
                    {
                        itemId : 'viewAgenda',
                        xtype: 'button',
                        text: 'Agenda'
                    },
                    {
                        itemId : 'viewToday',
                        xtype: 'button',
                        text: 'Today',
                        hidden: true
                    },
                    {
                        xtype: 'spacer'
                    },
                    {
                        itemId : 'appointmentSearchField',
                        xtype: 'searchfield',
                        placeHolder: 'ค้นหาตารางนัดหมาย',
                        align: 'right'
                    }
                ]
            }
        ]
    }
});