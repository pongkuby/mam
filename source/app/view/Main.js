Ext.define('Mam.view.Main', {
    extend: 'Ext.navigation.View',
    xtype: 'main',
    requires: [
        'Mam.view.Appointment',
        'Mam.store.Appointments',
        'Ext.tab.Panel'
    ],
    config: {
        itemId: 'main',
        fullscreen: true,
        ui: 'round',
        uid: null,
        vid: null,
        isOffline: false,
        currentView: "month",
        navigationBar: {
            ui: 'dark',
            items: [
                {
                    itemId: 'menuButton',
                    xtype: 'button',
                    text: 'Menu',
                    iconCls: 'list'
                },
                {
                    itemId: 'homeButton',
                    xtype: 'button',
                    align: 'center',
                    iconCls: 'home',
                    text: 'ปฏิทิน',
                    hidden: true
                },
                {
                    itemId: 'statOptionButton',
                    xtype: 'button',
                    iconCls: 'list',
                    align: 'right',
                    hidden: true
                },
                {
                    itemId: 'menuPanel',
                    xtype: 'panel',
                    modal: true,
                    hideOnMaskTap: true,
                    hidden: true,
                    items: [
                        {
                            itemId: 'addButton',
                            xtype: 'button',
                            iconCls: 'add',
                            text: 'นัดหมาย'
                        },
                        {
                            itemId: 'searchCalendarButton',
                            xtype: 'button',
                            align: 'right',
                            iconCls: 'search',
                            text: 'ปฏิทินบุคคลอื่น'
                        },
                        {
                            itemId: 'searchEmployeeButton',
                            xtype: 'button',
                            align: 'right',
                            iconCls: 'user',
                            text: 'ค้นหาเบอร์โทรศัพท์'
                        },
                        {
                            itemId: 'mwaAgendaButton',
                            xtype: 'button',
                            align: 'right',
                            iconCls: 'favorites',
                            iconMask: true,
                            text: 'ปฏิทินกิจกรรม กปน.'
                        },
                        {
                            itemId: 'userManualButton',
                            xtype: 'button',
                            align: 'right',
                            iconCls: 'maps',
                            iconMask: true,
                            text: 'คู่มือการใช้งาน'
                        },
                        {
                            itemId: 'showStatButton',
                            xtype: 'button',
                            align: 'right',
                            iconCls: 'team',
                            iconMask: true,
                            text: 'สถิติการใช้งานระบบ'
                        },
                        {
                            itemId: 'contactButton',
                            xtype: 'button',
                            align: 'right',
                            iconCls: 'info',
                            iconMask: true,
                            text: 'ติดต่อผู้ดูแลระบบ'
                        },
                        {
                            itemId: 'refreshButton',
                            xtype: 'button',
                            align: 'right',
                            iconCls: 'refresh',
                            iconMask: true,
                            text: 'Refresh'
                        },
                        {
                            itemId: 'logoutButton',
                            xtype: 'button',
                            align: 'right',
                            iconCls: 'reply',
                            text: 'Logout',
                            hidden: true
                        }
                    ]
                },
                {
                    itemId: 'downloadPhoneBookButton',
                    xtype: 'button',
                    iconCls: 'download',
                    align: 'right',
                    text: 'เล่มทำเนียบโทรศัพท์',
                    hidden: true
                }
            ]
        }
    }
});
