/**
 * Created by Thammarak.
 * Date: 2/6/2556
 * Time: 11:01 น.
 */
Ext.define('Mam.controller.Login', {
    extend: 'Ext.app.Controller',

    requires: [
        'Mam.view.MainCalendar',
        'Mam.view.Login',
        'Mam.store.LastLogin',
        'Mam.Util',
        'Mam.view.Main',
        'Mam.store.Login'
    ],

    config: {
        refs: {
            usernameTextField: 'fieldset #usernameTextField',
            passwordTextField: 'fieldset #passwordTextField',
            logInButton: 'login #loginButton',
            loginFail: 'fieldset #logInFailedLabel',
            manualButton: 'login #manualButton',
            menuButton: 'main #menuButton',
            addButton: 'panel #addButton',
            main: 'main',
            loginPanel: 'login'
        },

        control: {
            logInButton: {
                tap: 'onLogin'
            },
            manualButton: {
                tap: 'showManual'
            },
            usernameTextField: {
                focus: 'onUsernameFocus',
                keyup: 'onUsernameKeyup',
                clearicontap: 'onClearUsername'
            },
            passwordTextField: {
                focus: 'onPasswordFocus',
                keyup: 'onPasswordKeyup',
                clearicontap: 'onClearPassword'
            },
            main: {
                push: 'onPushView'
            },
            login: {
                initialize: 'onInitialize'
            }
        }
    },

    launch: function () {
        if (Ext.get('login') != null) {
            this.getUsernameTextField().enable();
            this.getPasswordTextField().enable();
            this.getLogInButton().enable();
            if (this.getusernameTextField().value == "") {
                Ext.getCmp('usernameTextField').focus('', 30);
            }
        }
        Ext.data.JsonP.request(
            {
                url: Mam.Util.getServerUrl() + '/service/test',
                success: function () {

                },
                failure: function () {
                    if (Ext.get('login') != null) {
                        this.getUsernameTextField().disable();
                        this.getPasswordTextField().disable();
                        this.getLogInButton().disable();
                        this.getLoginFail().setHtml('ไม่สามารถเชื่อมต่อ Internet ได้.');
                        this.getLoginFail().show();
                    }
                },
                scope: this
            }
        );
    },

    onInitialize: function (login, eOpts) {
        var textField = Ext.ComponentQuery.query("#usernameTextField")[0];
        textField.focus('', 30);
    },

    onLogin: function (button, e, eOpts) {
        var username = this.getUsernameTextField().getValue();
        var password = this.getPasswordTextField().getValue();
        var store = Ext.create('Mam.store.Login', {
            proxy: {
                type: 'jsonp',
                url: Mam.Util.getServerUrl() + "/service/login/" + username + "/" + password,
                reader: {
                    type: 'json',
                    rootProperty: 'result'
                }
            }
        });
        var lastLogin = Ext.getStore('lastLogin');
        if (lastLogin == null) {
            lastLogin = Ext.create("Mam.store.LastLogin");
        }
        store.load(
            function (records, operation, success) {
                if (records.length > 0) {
                    lastLogin.add({
                        empId: records[0].get('empId'),
                        fullName: records[0].get('firstName') + " " + records[0].get('lastName'),
                        lastView: "month"
                    });
                    lastLogin.sync();
                    Ext.Viewport.remove(this.getLoginPanel(), true);
                    var main = null;
                    if (Ext.os.is.Phone) {
                        main = this.getApplication().getController('Mam.controller.phone.Main');
                    }
                    else {
                        main = this.getApplication().getController('Mam.controller.Main');
                    }
                    main.launch();
                }
                else {
                    Mam.Util.writeLog("Unknown", " Login fail. (" + this.getUsernameTextField().getValue() + ")");
                    this.getLoginFail().show();
                }
            }, this
        );

    },

    onPasswordFocus: function (textField, e, eOpts) {
        this.getLoginFail().hide();
    },

    onPasswordKeyup: function (textField, e, eOpts) {
        if (e.event.keyCode == 13) {
            this.onLogin(null, e, eOpts);
        }
        this.getLoginFail().hide();
    },

    onUsernameKeyup: function () {
        this.getLoginFail().hide();
    },

    onClearUsername: function () {
        this.getLoginFail().hide();
        this.getUsernameTextField().focus();
    },

    onClearPassword: function () {
        this.getLoginFail().hide();
        this.getPasswordTextField().focus();
    },

    showManual: function () {
        var view = Ext.create('Ext.NavigationView', {
            fullscreen: true,
            items: [
                {
                    title: 'คู่มือการใช้งานระบบ',
                    items: [
                        {
                            xtype: 'panel'
                        }
                    ]
                }
            ],
            listeners: {
                back: function () {
                    var login = Ext.create('Mam.view.Login');
                    Ext.Viewport.add(login);
                    Ext.Viewport.remove(Ext.Viewport.getActiveItem(), true);
                    Ext.Viewport.setActiveItem(login);
                }
            }
        });
        view.push(
            Ext.create("Ext.ux.Iframe", {
                    title: 'คู่มือการใช้งานระบบ M@M',
                    href: Mam.Util.getServerUrl() + "/manual"}
            ));
        Ext.Viewport.remove(this.getLoginPanel(), true);
        Ext.Viewport.add(view);
    },

    onPushView: function (navView, pushView, eOpts) {
        if (pushView.id == "login") {
            this.getMenuButton().hide();
            this.getAddButton().hide();
        }
    }
});