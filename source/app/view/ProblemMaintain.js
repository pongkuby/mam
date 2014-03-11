/**
 * Created by Thammarak.
 * Date: 30/1/2557
 * Time: 15:47 น.
 */
Ext.define('Mam.view.ProblemMaintain', {
    extend: 'Ext.form.Panel',
    xtype: 'problemmaintain',
    config: {
        items: [
            {
                xtype: 'titlebar',
                title: 'แจ้งปัญหาการใช้งานระบบ M@M',
                docked: 'top',
                items: [
                    {
                        xtype: 'button',
                        itemId: 'backFromProblemMaintainButton',
                        ui: 'back',
                        text: 'back'
                    },
                    {
                        xtype: 'button',
                        itemId: 'saveProblemButton',
                        text: 'บันทึก',
                        align: 'right',
                        iconCls: 'organize'
                    }
                ]
            },
            {
                xtype: 'fieldset',
                itemId:'problemFieldset',
                items: [
                    {
                        xtype: 'textfield',
                        name: 'title',
                        itemId: 'title',
                        label: 'ปัญหา:'
                    },
                    {
                        xtype: 'textareafield',
                        name: 'detail',
                        itemId: 'detail',
                        label: 'รายละเอียด:',
                        maxRows: 4
                    },
                    {
                        xtype: 'hiddenfield',
                        name: 'empId',
                        itemId: 'empId'
                    }
                ]
            }
        ]
    }
});