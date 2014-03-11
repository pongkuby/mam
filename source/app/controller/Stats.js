/**
 * Created by Thammarak on 15/2/2557.
 */
Ext.define('Mam.controller.Stats', {
    extend: 'Ext.app.Controller',

    requires: [
        'Mam.view.Stats',
        'Mam.view.Main',
        'Mam.Util',
        'Ext.data.proxy.JsonP',
        'Mam.model.NameValue',
        'Mam.model.Activitylog'
    ],

    config: {
        refs: {
            main: 'main',
            stats: 'stats',
            chartSelector: 'container #chartSelector',
            chartContainer: 'stats #chartContainer',
            fromDate: 'container #fromDate',
            toDate: 'container #toDate',
            pieChart: 'container #pieChart',
            lineChart: 'container #lineChart',
            statList: 'container #statList',
            optionButton: 'main #statOptionButton',
            optionPanel: 'stats #optionPanel'
        },

        control: {
            chartSelector: {
                select: 'chartSelect'
            },
            optionButton: {
                tap: 'optionTap'
            },
            main: {
                back: 'onNavigateBack'
            },
            fromDate: {
                change: 'loadSelectChart'
            },
            toDate: {
                change: 'loadSelectChart'
            }
        },

        routes: {
            'viewstat': 'viewStat'
        }
    },

    viewStat: function () {
        this.getOptionButton().show();
        this.getMain().push(Ext.create('Mam.view.Stats'));
        this.getChartSelector().select(1, false, false);
        if (Ext.os.is.Phone) {
            this.getOptionPanel().hide();
        }
    },

    chartSelect: function (list, record) {
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        this.getFromDate().setValue(firstDay);
        this.getStats().setCurrentChart(record.get('id'));
        switch (record.get('id')) {
            case "os":
                this.loadOSChart();
                this.getChartContainer().setActiveItem(0);
                break;
            case "browser":
                this.loadBrowserChart();
                this.getChartContainer().setActiveItem(0);
                break;
            case "monthly":
                this.loadLineChart();
                this.getChartContainer().setActiveItem(1);
                break;
            case "list":
                var today = new Date();
                var yesterday = new Date();
                yesterday.setDate(today.getDate() - 1);
                this.getFromDate().setValue(yesterday);
                this.loadStatList();
                this.getChartContainer().setActiveItem(2);
                break;
            default:
                break;
        }
    },

    loadSelectChart: function () {
        switch (this.getStats().getCurrentChart()) {
            case "os":
                this.loadOSChart();
                this.getChartContainer().setActiveItem(0);
                break;
            case "browser":
                this.loadBrowserChart();
                this.getChartContainer().setActiveItem(0);
                break;
            case "monthly":
                this.loadLineChart();
                this.getChartContainer().setActiveItem(1);
                break;
            case "list":
                this.loadStatList();
                this.getChartContainer().setActiveItem(2);
                break;
        }
    },

    loadBrowserChart: function () {
        var fromDate = this.getFromDate().getValue();
        var toDate = this.getToDate().getValue();
        var myStore = Ext.create("Ext.data.Store", {
            model: 'Mam.model.NameValue',
            proxy: {
                type: 'jsonp',
                url: Mam.Util.getServerUrl() + '/service/getbrowserstats/'
                    + fromDate.yyyymmdd() + '/' + toDate.yyyymmdd(),
                callbackKey: 'callback',
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            },
            autoLoad: true
        });
        this.getPieChart().setStore(myStore);
    },

    loadOSChart: function () {
        var fromDate = this.getFromDate().getValue();
        var toDate = this.getToDate().getValue();
        var myStore = Ext.create("Ext.data.Store", {
            model: 'Mam.model.NameValue',
            proxy: {
                type: 'jsonp',
                url: Mam.Util.getServerUrl() + '/service/getosstats/'
                    + fromDate.yyyymmdd() + '/' + toDate.yyyymmdd(),
                callbackKey: 'callback',
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            },
            autoLoad: true
        });
        this.getPieChart().setStore(myStore);
    },

    loadLineChart: function () {
        var fromDate = this.getFromDate().getValue();
        var toDate = this.getToDate().getValue();
        var myStore = Ext.create("Ext.data.Store", {
            model: 'Mam.model.NameValue',
            proxy: {
                type: 'jsonp',
                url: Mam.Util.getServerUrl() + '/service/gettotalstats/'
                    + fromDate.yyyymmdd() + '/' + toDate.yyyymmdd(),
                callbackKey: 'callback',
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            }
        });
        myStore.load(
            function (records, operation, success) {
                this.getLineChart().setStore(myStore);
            }, this
        );
    },

    loadStatList: function () {
        var fromDate = this.getFromDate().getValue();
        var toDate = this.getToDate().getValue();
        var list = this.getStatList();
        var myStore = Ext.create("Ext.data.Store", {
            model: 'Mam.model.Activitylog',
            proxy: {
                type: 'jsonp',
                url: Mam.Util.getServerUrl() + '/service/getemployeestats/'
                    + fromDate.yyyymmdd() + '/' + toDate.yyyymmdd(),
                callbackKey: 'callback',
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            },
            autoLoad: true,
            sorters: [
                {
                    property: 'activity_time',
                    direction: 'ASC'
                }
            ]
        });
        list.setMasked({
            xtype: 'loadmask',
            message: 'Loading..'
        });
        list.setStore(myStore);
        list.refresh();
    },

    optionTap: function () {
        if (this.getOptionPanel().getHidden()) {
            this.getOptionPanel().show();
        }
        else {
            this.getOptionPanel().hide();
        }
    },

    onNavigateBack: function (view, eOpts) {
        if (view.xtype == "main") {
            this.getOptionButton().hide();
        }
    },

    fromDatechange: function (dp, newDate, oldDate, eOpts) {

    }
});