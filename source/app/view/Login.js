/**
 * Created by Thammarak.
 * Date: 28/5/2556
 * Time: 9:48 น.
 */
Ext.define('Mam.view.Login', {
    extend: 'Ext.form.Panel',
    xtype: 'login',
    requires: [
        "Ext.Img",
        "Ext.Label"
    ],
    config: {
        itemId: 'login',
        title: 'My Appointment on Mobile',
        fullscreen: true,
        items: [
            {
                xtype: 'toolbar',
                docked: 'top',
                title: 'Login'
            },
            {
                xtype: 'image',
                itemId:'loginImg',
                src: 'resources/images/login.png',
                style: 'width:180px;height:180px;margin:auto'
            },
            {
                xtype: 'fieldset',
                title: 'Login',
                items: [
                    {
                        xtype: 'textfield',
                        placeHolder: 'รหัสพนักงาน 8 หลัก',
                        itemId: 'usernameTextField',
                        name: 'usernameTextField',
                        required: true
                    },
                    {
                        xtype: 'passwordfield',
                        placeHolder: 'วัน เดือน พ.ศ.เกิด DDMMYYYY',
                        itemId: 'passwordTextField',
                        name: 'passwordTextField',
                        required: true
                    },
                    {
                        xtype: 'label',
                        html: 'กรุณาตรวจสอบ รหัสพนักงาน หรือ วันเกิดให้ถูกต้อง',
                        itemId: 'logInFailedLabel',
                        hidden: true,
                        hideAnimation: 'fadeOut',
                        showAnimation: 'fadeIn',
                        style: 'color:red ;margin:10px'
                    }
                ]
            },
            {
                xtype: 'button',
                itemId: 'loginButton',
                ui: 'action',
                padding: '10px',
                text: 'Log In'
            },
            {
                xtype: 'button',
                itemId: 'manualButton',
                padding: '10px',
                text: 'User Manual'
            }
        ]
    }
});