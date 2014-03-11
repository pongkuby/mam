/**
 * TouchCalendar.view.MainTabPanel
 */
Ext.define('Mam.view.phone.MainCalendar', {
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
        itemId: 'mainCalendar',
        fullscreen: true,
        layout: 'card',
        agendaStore: null,
        currentView: 'month',
        items: [
            {
                xtype: 'toolbar',
                docked: 'top',
                items: [
                    {
                        itemId: 'viewButton',
                        xtype: 'button',
                        text: 'Month'
                    },
                    {
                        itemId: 'viewList',
                        xtype: 'panel',
                        fullscreen: false,
                        modal: true,
                        hideOnMaskTap: true,
                        hidden: true,
                        items: [
                            {
                                itemId: 'viewMonth',
                                xtype: 'button',
                                text: 'Month',
                                disabled: true,
                                icon: 'resources/icons/view_month-icon.png'
                            },
                            {
                                itemId: 'viewWeek',
                                xtype: 'button',
                                text: 'Week',
                                icon: 'resources/icons/view_week-icon.png'
                            },
                            {
                                itemId: 'viewDay',
                                xtype: 'button',
                                text: 'Day',
                                icon: 'resources/icons/view_day-icon.png'
                            },
                            {
                                itemId: 'viewAgenda',
                                xtype: 'button',
                                text: 'Agenda',
                                icon: 'resources/icons/view_agenda-icon.png'
                            },
                            {
                                itemId: 'viewToday',
                                xtype: 'button',
                                text: 'Today',
                                hidden: true
                            }
                        ]
                    },
                    {
                        xtype: 'spacer'
                    },
                    {
                        itemId: 'appointmentSearchField',
                        xtype: 'searchfield',
                        placeHolder: 'ค้นหาตารางนัดหมาย',
                        align: 'right'
                    }
                ]
            }
        ]
    }
});