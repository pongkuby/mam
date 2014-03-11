/**
 * เป็น View สำหรับผู้ติดต่อระบบ
 * Created by Thammarak.
 * Date: 7/2/2557
 * Time: 11:42 น.
 */
Ext.define('Mam.view.ContactUs', {
    extend: 'Ext.Container',
    xtype: 'contactus',
    requires: [
        'Ext.dataview.List',
        'Ext.Toolbar'
    ],
    config: {
        layout: 'fit',
        items: [
            {
                xtype: 'titlebar',
                title: 'ผู้ดูแลระบบ',
                docked: 'top',
                items: [
                    {
                        xtype: 'button',
                        itemId: 'backFromContactUsButton',
                        ui: 'back',
                        text: 'back'
                    },
                    {
                        xtype: 'button',
                        itemId: 'viewProblemButton',
                        text: 'ปัญหาการใช้งาน',
                        align: 'right',
                        iconCls: 'compose'
                    }
                ]
            },
            {
                xtype: 'list',
                disableSelection: true,
                data: [
                    {
                        firstName: 'นำเกียรติ',
                        lastName: 'วิริยะเสรีธรรม',
                        position: 'นักคอมพิวเตอร์ 3',
                        division: 'สพพ.กพบ.ฝพท.',
                        email: 'namkiat.v@mwa.co.th',
                        phone: '025040123',
                        ext_no: ' ต่อ 1317'
                    },
                    {
                        firstName: 'ธรรมรักษ์',
                        lastName: 'เติมทองสุขสกุล',
                        position: 'นักคอมพิวเตอร์ 3',
                        division: 'สพง.กพบ.ฝพท.',
                        email: 'thammarak.t@mwa.co.th',
                        phone: '025040123',
                        ext_no: ' ต่อ 1396'
                    },
                    {
                        firstName: 'ณัฐวัฒน์',
                        lastName: 'พรอโนทัย',
                        position: 'นักคอมพิวเตอร์ 3',
                        division: 'สพง.กพบ.ฝพท.',
                        email: 'nattawat.p@mwa.co.th',
                        phone: '025040123',
                        ext_no: ' ต่อ 1396'
                    }
                ],
                itemTpl: [
                    "<div><b>{firstName} {lastName}</b><div>" ,
                    "<div><img src='resources/icons/position-icon.png'>{position}</div>",
                    "<div><span><img src='resources/icons/division-icon.png'></span><span>{division}</span></div>",
                    "<div><a href='mailto:{email}' style='text-decoration: none'><img src='resources/icons/Mail-icon.png'> {email}</a></div>" ,
                    "<div><a href='tel:{phoneOnly}' style='text-decoration: none'><img src='resources/icons/Phone-icon.png'> {phone}</a>&nbsp;{ext_no}</div>"
                ]
            }

        ]
    }
});