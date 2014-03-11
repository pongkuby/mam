/**
 * Created by Thammarak.
 * Date: 30/1/2557
 * Time: 15:47 น.
 */
Ext.define('Mam.view.ProblemList', {
    extend: 'Ext.Container',
    xtype: 'problemlist',
    config: {
        itemId: 'problemList',
        layout:'fit',
        items: [
            {
                xtype: 'titlebar',
                title: 'ปัญหาการใช้งานระบบ M@M.',
                docked: 'top',
                items:[
                    {
                        xtype: 'button',
                        itemId: 'backFromProblemListButton',
                        ui: 'back',
                        text: 'back'
                    },
                    {
                        xtype: 'button',
                        itemId: 'addProblemButton',
                        text: 'แจ้งปัญหา',
                        align: 'right',
                        iconCls: 'add'
                    }
                ]
            },
            {
                xtype: 'list',
                id:'problemList',
                itemTpl: [
                    '<div style="font-weight:bold;">{title}</div>',
                    '<div style="margin: 5px;">{detail}</div>',
                    '<div style="margin: 5px;">{fullName}</div>',
                    '<div style="margin: 5px;">{postDate}</div>'
                ],
                data: [
                    {
                        title: 'ปัญหาการ Login',
                        detail: 'หน้า Login ไม่สามารถใช้งานได้',
                        fullName: 'ธรรมรักษ์ เติมทองสุขสกุล',
                        postDate: '2014-02-26 10:35'
                    },
                    {
                        title: 'ปัญหาการดู User Manual',
                        detail: 'User Manual แสดงไม่ถูกต้อง',
                        fullName: 'ธรรมรักษ์ เติมทองสุขสกุล',
                        postDate: '2014-02-27 10:35'
                    },
                    {
                        title: 'รายงานสถิติการใช้งานไม่ถูกต้อง',
                        detail: 'กด Back แล้วไม่สามารถกลบไปได้',
                        fullName: 'ธรรมรักษ์ เติมทองสุขสกุล',
                        postDate: '2014-02-28 10:35'
                    }
                ]
            }
        ]
    }
});