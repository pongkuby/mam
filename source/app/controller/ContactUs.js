/**
 * Created by Thammarak.
 * Date: 27/1/2557
 * Time: 7:37 น.
 */
Ext.define('Mam.controller.ContactUs', {
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
            main: 'main',
            viewProblemButton: 'titlebar #viewProblemButton',
            backFromContactUsButton: 'titlebar #backFromContactUsButton',
            menuButton: 'main #menuButton',
            menuPanel: '#menuPanel',
            addButton: 'panel #addButton',
            contactUs: 'contactus'
        },

        control: {
            backFromContactUsButton: {
                tap: 'onBackFromContact'
            },
            viewProblemButton: {
                tap: 'onViewProblemButtonTap'
            }
        },

        routes: {
            'contactus': 'viewContactUs'
        }
    },

    onViewProblemButtonTap: function () {
        window.location.href = "#viewproblemlist";
    },

    onBackFromContact: function () {
        history.back();
        Ext.Viewport.remove(this.getContactUs(), true);
    },

    viewContactUs: function () {
        Ext.create("Mam.view.ContactUs");
        if(Ext.os.is.Phone)
        {
            this.getViewProblemButton().setText("");
        }
        Ext.Viewport.setShowAnimation("slideIn");
        Ext.Viewport.add(this.getContactUs());
        Ext.Viewport.setActiveItem(this.getContactUs());
    }
});