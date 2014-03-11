/**
 * Created by Thammarak.
 * Date: 15/1/2557
 * Time: 13:50 น.
 */
Ext.define('Mam.view.PhoneBooks', {
    extend: 'Ext.dataview.List',
    xtype: 'phonebooks',
    config: {
        title:'ทำเนียบโทรศัพท์',
        data: [
            {
                name: 'สายงานผู้ว่าการ',
                fileName: '01ผวก.pdf'
            },
            {
                name: 'สายงานบริหาร',
                fileName: '02บริหาร.pdf'
            },
            {
                name: 'สายงานการเงิน',
                fileName: '03การเงิน.pdf'
            },
            {
                name: 'สายงานแผนและพัฒนา',
                fileName: '06แผน.pdf'
            },
            {
                name: 'สายงานบริการ',
                fileName: '07บริการ.pdf'
            },
            {
                name: 'สายงานผลิตและส่งน้ำ',
                fileName: '05ผลิต.pdf'
            },
            {
                name: 'สายงานวิศวกรรมและก่อสร้าง',
                fileName: '04วิศว.pdf'
            },
            {
                name: 'สายงานเทคโนโลยีสารสนเทศ',
                fileName: '08เทคโน.pdf'
            }
        ],
        itemTpl: '<div>{name}</div>'
    }
});