/**
 * Created by Thammarak.
 * Date: 11/9/2556
 * Time: 11:19 น.
 */
Ext.define('Mam.Util', {
        statics: {
            getServerUrl: function () {
                return "http://localhost/mam";
//                return "http://mam.mwa.co.th/mam";
            },

            /**
             * ลง Activity Log
             * */
            writeLog: function (empId, message) {
                var resolution = screen.width + ' x ' + screen.height;
                Ext.data.JsonP.request({
                    url: Mam.Util.getServerUrl() + '/service/log/' + empId + '/' + message + '/' + resolution,
                    callbackKey: 'callback'
                });
            },

            /**
             * Format วันที่
             * */
            formatDate: function (date) {
                var d = new Date(date || Date.now()),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day ].join('-');
            },

            /**
             * Return เดือนปัจจุบัน
             * */
            getCurrentMonth: function () {
                var currentTime = new Date();
                return currentTime.getMonth() + 1;
            },

            /**
             * Return ปีปัจจุบัน
             * */
            getCurrentYear: function () {
                var currentTime = new Date();
                return currentTime.getFullYear();
            },

            /**
             * Return วันที่ปัจจุบัน
             * */
            getCurrentDate: function () {
                return new Date();
            },

            /**@return LastLogin*/
            getCurrentLogin: function () {
                var lastLogin = Ext.getStore('lastLogin');
                if (lastLogin == null) {
                    lastLogin = Ext.create("Mam.store.LastLogin");
                }
                lastLogin.load();
                return lastLogin.getRange()[0].data;
            }
        }
    }
);

Date.prototype.ddmmyyyy = function () {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return (dd[1] ? dd : "0" + dd[0]) + '-' + (mm[1] ? mm : "0" + mm[0]) + '-' + yyyy;
};

Date.prototype.yyyymmdd = function () {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return yyyy + '-' + (mm[1] ? mm : "0" + mm[0]) + '-' + (dd[1] ? dd : "0" + dd[0]);
};