Ext.define('Mam.controller.Appointment', {
    extend: 'Ext.app.Controller',
    requires: [
        'Ext.data.Store',
        'Mam.model.Employee',
        'Mam.store.Employees'
    ],

    config: {
        views: [
            'Appointment'
        ],

        refs: {
            appointmentForm: '#appointmentForm',
            isAllDay: '#isAllDay',
            startTime: '#startTime',
            endTime: '#endTime'
        },

        control: {
            appointmentForm: {
                initialize: 'onAppointmentInitialize'
            },
            isAllDay: {
                change: 'allDayChanged'

            }
        }
    },

    launch: function (app) {

    },

    onAppointmentInitialize: function (form, eOpts) {
        this.getAppointmentForm().setTitle(this.getAppointmentForm().getMode() + " Appointment");
    },

    /**
     * Called with the search action above. Searches twitter for a specified search term or record
     */
    doSearch: function (search) {
        var model = Twitter.model.Search,
            tweetList = this.getTweetList(),
            searchList = this.getSearchList(),
            searchesStore = Ext.getStore('Searches'),
            searchField = this.getSearchField(),
            query, index;

        // ensure there is a search...
        if (!search) {
            return;
        }

        //ensure the tweetlist is visible
        tweetList.show();

        //check if ths search already exists in the searchesStore
        index = searchesStore.find('query', search);
        if (index != -1) {
            //it exists, so lets just select it
            search = searchesStore.getAt(index);

            searchList.select(search);

            //empty the field and blur it so it looses focus
            searchField.setValue('');
            searchField.blur();

            return;
        }

        //if the passed argument is not an instance of a Search mode, create a new instance
        if (!(search instanceof Twitter.model.Search)) {
            query = search.replace("%20", " ");
            search = new model({
                query: query
            });
        }

        //add the new search instance to the searchsStore
        searchesStore.add(search);
        searchesStore.sync();

        // select the new record in the list
        searchList.select(search);

        //empty the field and remove focus from it
        searchField.setValue('');
        searchField.blur();
    },

    allDayChanged: function (component, Slider, Thumb, newValue, oldValue, eOpts) {
        if (newValue == 1) {
            this.getStartTime().hide();
            this.getEndTime().disable();
        }
        else {
            this.getStartTime().enable();
            this.getEndTime().enable();
        }
    },

    onSubmit: function () {
    }
});