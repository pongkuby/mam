/**
 * Created by Thammarak.
 * Date: 27/1/2557
 * Time: 7:37 น.
 */
Ext.define('Mam.controller.Problem', {
    extend: 'Ext.app.Controller',

    requires: [
        'Mam.view.ProblemList',
        'Mam.view.ProblemMaintain',
        'Mam.view.ContactUs',
        'Mam.Util',
        'Mam.model.Problem',
        'Ext.data.proxy.JsonP'
    ],

    config: {
        refs: {
            contactButton: 'panel #contactButton',
            problemList: 'problemlist',
            addButton: 'problemlist #addProblemButton',
            maintainProblem: 'problemmaintain',
            backFromMaintainButton: 'titlebar #backFromProblemMaintainButton',
            backFromProblemListButton: 'titlebar #backFromProblemListButton',
            titleField: 'fieldset #title',
            saveProblemButton: 'titlebar #saveProblemButton',
            main: 'main'
        },

        control: {
            addButton: {
                tap: 'addButtonTap'
            },
            backFromMaintainButton: {
                tap: 'backFromMaintainButtonTap'
            },
            saveProblemButton: {
                tap: 'saveProblem'
            },
            backFromProblemListButton: {
                tap: 'backFromProblemListButtonTap'
            }
        },

        routes: {
            'viewproblemlist': 'viewProblemList',
            'addproblem': 'addProblem',
            'viewproblem/:problemId': 'showProductInFormat'
        }
    },

    viewProblemList: function () {
        Ext.create("Mam.view.ProblemList");
        this.getAddButton().setText("");
        Ext.Viewport.add(this.getProblemList());
        Ext.Viewport.setActiveItem(this.getProblemList());
    },

    initialize: function (list, eOpts) {
        var myStore = Ext.create("Ext.data.Store", {
            model: 'Mam.model.Appointment',
            proxy: {
                type: 'jsonp',
                url: Mam.Util.getServerUrl() + '/service/getdailyappointments/' + list.getUid() + '/'
                    + Mam.Util.formatDate(list.getCurrentDate()),
                reader: {
                    type: 'json',
                    rootProperty: 'appointments'
                }
            },
            autoLoad: true
        });
        list.setMasked({
            xtype: 'loadmask',
            message: 'Loading..'
        });
        list.setStore(myStore);
        list.refresh();
        list.setEmptyText("ไม่พบตารางนัดหมาย");
    },

    itemtap: function (list, index, target, record, e, eOpts) {
        if (record.get("appType") != 0) {
            window.location = Mam.Util.getServerUrl() + "/mam/view_meeting.php?aid="
                + record.get("appId") + "&uid=" + list.getUid()
                + "&currentview=" + list.getMainCurrentView();
        }
    },

    addProblem: function () {
        Ext.create("Mam.view.ProblemMaintain", {
            record: Ext.create('Mam.model.Problem')
        });
        Ext.Viewport.add(this.getMaintainProblem());
        Ext.Viewport.setActiveItem(this.getMaintainProblem());
    },

    addButtonTap: function () {
        window.location.href = "#addproblem";
    },

    backFromMaintainButtonTap: function () {
        history.back();
        Ext.Viewport.remove(this.getMaintainProblem(), true);
    },

    backFromProblemListButtonTap: function () {
        history.back();
        Ext.Viewport.remove(this.getProblemList(), true);
    },

    saveProblem: function () {
        var formValues = this.getMaintainProblem().getValues();
        var problem = Ext.create('Mam.model.Problem', {
                empId: Mam.Util.getCurrentLogin().empId,
                title: formValues.title,
                detail: formValues.detail
            }
        );
        problem.save();
    }
});