/**
 * Created by Thammarak.
 * Date: 2/6/2556
 * Time: 11:01 �?.
 */
Ext.define('Mam.controller.SearchEmployee', {
    extend: 'Ext.app.Controller',

    requires: [
        'Ext.ux.Iframe',
        'Mam.Util',
        'Mam.view.SearchEmployee',
        'Mam.view.PhoneBooks'
    ],

    config: {
        refs: {
            main: 'main',
            employeeSearchField: '#employeeSearchField',
            downloadPhoneBookButton: 'main #downloadPhoneBookButton',
            beginSearchEmployee: '#beginSearchEmployee',
            phoneBooks: 'phonebooks',
            searchEmployee: 'searchemployee',
            menuButton: '#menuButton',
            addButton: '#addButton'
        },

        control: {
            searchEmployee: {
                initialize: 'onInitialize'
            },
            employeeSearchField: {
                keyup: 'onKeyup',
                clearicontap: 'onClearSearchTap'
            },
            downloadPhoneBookButton: {
                tap: 'onDownloadPhoneBookButtonTap'
            },
            beginSearchEmployee: {
//                tap: 'doSearch'
            },
            phoneBooks: {
                itemtap: 'onPhoneBooksTap'
            },
            main: {
                push: 'onPushView',
                back: 'onNavigateBack'
            }
        }
    },

    onInitialize: function (list, eOpts) {
        if(Ext.os.is.Phone)
        {
            this.getBeginSearchEmployee().setText("");
        }
        this.getBeginSearchEmployee().addListener(
            {
                tap: function () {
                    this.doSearch();
                },
                scope: this
            });
        this.getEmployeeSearchField().addListener(
            {
                keyup: function (field, e, eOpts) {
                    this.onKeyup(field, e, eOpts);
                },
                clearicontap: function () {
                    this.onClearSearchTap();
                },
                scope: this
            });
        var store = Ext.create('Mam.store.Employees', {
            storeId: 'searchEmployeeStore'
        });
        this.getSearchEmployee().setStore(store);
        this.getSearchEmployee()
            .setItemTpl(["<div><b>{firstName} {lastName}</b><div>" ,
                "<div><img src='resources/icons/position-icon.png'>{position}</div>",
                "<div><span><img src='resources/icons/division-icon.png'></span><span>{division}</span></div>",
                "<div><a href='mailto:{email}' style='text-decoration: none'><img src='resources/icons/Mail-icon.png'> {email}</a></div>" ,
                "<div><a href='tel:{mobilePhone}' style='text-decoration: none'><img src='resources/icons/Smartphone-icon.png'> {mobilePhone}</a></div>",
                "<div><a href='tel:{phoneOnly}' style='text-decoration: none'><img src='resources/icons/Phone-icon.png'> {phone}</a>&nbsp;{ext_no}</div>"]);
        this.getEmployeeSearchField().focus();
    },

    onKeyup: function (field, e, eOpts) {
        if (e.event.keyCode == 13) {
            this.doSearch();
        }
    },

    /**
     * Called when the user taps on the clear icon in the search field.
     * It simply removes the f
     */
    onClearSearchTap: function () {
        var store = this.getSearchEmployee().getStore();
        var records = store.getRange();
        store.remove(records);
        Ext.getCmp('employeeSearchField').focus('', 20);
    },

    onDownloadPhoneBookButtonTap: function (button, e, eOpts) {
        if (this.getPhoneBooks() == null) {
            Ext.create("Mam.view.PhoneBooks");
        }
        this.getMain().push(this.getPhoneBooks());
        this.getDownloadPhoneBookButton().hide();
    },

    doSearch: function () {
        var value = this.getEmployeeSearchField().getValue();
        if (value.trim() == "") {
            this.onClearSearchTap();
        } else {
            var store = Ext.create('Mam.store.Employees', {
                model: 'Mam.model.Employee',
                autoLoad: true,
                proxy: {
                    type: 'jsonp',
                    url: Mam.Util.getServerUrl() + "/service/getemployees/" + value.trim(),
                    reader: {
                        type: 'json',
                        rootProperty: 'employees'
                    }
                },
                sorters: [
                    {
                        property: 'sub_group',
                        direction: 'DESC'
                    },
                    {
                        property: 'ee_group',
                        direction: 'DESC'
                    },
                    {
                        property: 'firstName',
                        direction: 'ASC'
                    }
                ]
            });
            this.getSearchEmployee().setStore(store);
            this.getSearchEmployee().refresh();
        }
    },

    onPhoneBooksTap: function (list, index, node, record) {
        url = Mam.Util.getServerUrl() + "/resources/upload/phonebooks/" + record.get('fileName');
        if (Ext.os.is('iOS') || Ext.os.is('iPad') || Ext.os.is('iPhone')) {
            this.getMain().push(
                Ext.create("Ext.ux.Iframe", {
                        href: url}
                ));
        }
        else {
            try {
                Ext.device.Device.openURL(url);
            } catch (err) {
                window.open(url, '_blank');
            }
        }
    },

    onPushView: function (navView, pushView, eOpts) {
        if (pushView.xtype == "searchemployee") {
            this.getAddButton().hide();
            this.getMenuButton().hide();
            this.getDownloadPhoneBookButton().enable();
        }
    },

    onNavigateBack: function (view, eOpts) {
        if (view.xtype == "main") {
            if (view.getActiveItem().xtype == "searchemployee") {
                this.getAddButton().hide();
                this.getMenuButton().hide();
                this.getDownloadPhoneBookButton().show();
            }
        }
    }
});