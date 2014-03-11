<html>
<head>
    <meta charset="utf-8">
    <title>MAM - REST API</title>
    <style type="text/css">
        html, body, div, span, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        abbr, address, cite, code,
        del, dfn, em, img, ins, kbd, q, samp,
        small, strong, sub, sup, var,
        b, i,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
        }

        body {
            line-height: 1;
        }

        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section {
            display: block;
        }

        nav ul {
            list-style: none;
        }

        blockquote, q {
            quotes: none;
        }

        blockquote:before, blockquote:after,
        q:before, q:after {
            content: '';
            content: none;
        }

        a {
            margin: 0;
            padding: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
        }

        ins {
            background-color: #ff9;
            color: #000;
            text-decoration: none;
        }

        mark {
            background-color: #ff9;
            color: #000;
            font-style: italic;
            font-weight: bold;
        }

        del {
            text-decoration: line-through;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #cccccc;
            margin: 1em 0;
            padding: 0;
        }

        input, select {
            vertical-align: middle;
        }

        html {
            background: #EDEDED;
            height: 100%;
        }

        body {
            background: #FFF;
            margin: 0 auto;
            min-height: 100%;
            padding: 0 30px;
            width: 440px;
            color: #666;
            font: 14px/23px Arial, Verdana, sans-serif;
        }

        h1, h2, h3, p, ul, ol, form, section {
            margin: 0 0 20px 0;
        }

        h1 {
            color: #333;
            font-size: 20px;
            border: 1px;
        }

        h2, h3 {
            color: #333;
            font-size: 14px;
        }

        h3 {
            margin: 0;
            font-size: 12px;
            font-weight: bold;
        }

        ul, ol {
            list-style-position: inside;
            color: #999;
        }

        ul {
            list-style-type: square;
        }

        code, kbd {
            background: #EEE;
            border: 1px solid #DDD;
            border: 1px solid #DDD;
            border-radius: 4px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            padding: 0 4px;
            color: #666;
            font-size: 12px;
        }

        pre {
            background: #EEE;
            border: 1px solid #DDD;
            border-radius: 4px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            padding: 5px 10px;
            color: #666;
            font-size: 12px;
        }

        pre code {
            background: transparent;
            border: none;
            padding: 0;
        }

        a {
            color: #70a23e;
        }

        header {
            padding: 30px 0;
            text-align: center;
        }

        p {
            padding-left: 10px;
        }
    </style>
</head>
<body>
<h1>API List</h1>

<h2><a href="login/username/password" target="_blank">login/username/password</a></h2>

<p>check Login</p>

<h2><a href="getemployee/empid" target="_blank">getemployee/empId</a></h2>

<p>ดึงข้อมูล Employee โดยใช้ ID</p>

<h2><a href="getemployees/name" target="_blank">getemployees/name</a></h2>

<p>ใช้หา Employee ตามชื่อที่กรอกเข้ามา</p>

<h2><a href="getallemployee/name" target="_blank">getallemployee/name</a></h2>

<p>ใช้หา Employee ทั้งหมด</p>

<h2><a href="getappointment/appid" target="_blank">getappointment/appid</a></h2>

<p>ดึง Appointment โดยใช้ id</p>

<h2><a href="getappointments/empid/year/month" target="_blank">getappointments/empid/year/month</a></h2>

<p>ดึง Appointment ของ User เป็นรายเดือน</p>

<h2><a href="getappointments/empid/year/excludemonth/excludemonth" target="_blank">getappointments/empid/year/excludemonth/excludemonth</a>
</h2>

<p>ดึง Appointment ของ User เป็นรายปี</p>

<h2><a href="viewappointments/empid/year/month/viewerid" target="_blank">viewappointments/empid/year/month/viewerid</a>
</h2>

<p>view Appointment ของ User เป็นรายเดือน</p>

<h2><a href="viewappointments/empid/year/viewerid/excludemonth/excludemonth" target="_blank">viewappointments/empid/year/viewerid/excludemonth/excludemonth</a>
</h2>

<p>view Appointment ของ User เป็นรายปี</p>

<h2><a href="deleteappointment/appid" target="_blank">deleteappointment/appid</a></h2>

<p>ลบ Appointment โดยใช้ id</p>

<h2><a href="getholidays/year/month" target="_blank">getholidays/year/month</a></h2>

<p>ดึงข้อมูลวันหยุด</p>

<h2><a href="getappointments/empid/keyword" target="_blank">getappointments/empid/keyword</a></h2>

<p>ค้นหา Appointment ของ User ด้วย Keyword</p>

<h2><a href="delete_file_app/filename" target="_blank">delete_file_app/filename</a></h2>

<p>ลบไฟล์ประกอบ Appointment โดยใช้ชื่อไฟล์</p>

<h2><a href="getdailyappointments/empid/date" target="_blank">getdailyappointments/empid/date</a></h2>

<p>ดึง Appointment ของ User ตามวันที่</p>

<h2><a href="getbookingroombymonth/fromDate" target="_blank">getbookingroombymonth/fromDate</a></h2>

<p>ดึงตารางจองห้องประชุมตามเดือนและปี</p>

<h2><a href="getlastmodifieddate/empid" target="_blank">getlastmodifieddate/empId</a></h2>

<p>ดึงวันที่ update ล่าสุดของตารางนัดหมาย</p>

<h2><a href="log/empId/message/resolution" target="_blank">log/empId/message/resolution</a></h2>

<p>Write Activity Log</p>


<h2><a href="getappointmentalert/empid/alertdate" target="_blank">getappointmentalert/empid/alertdate</a></h2>

<p>ดึงการแจ้งเตือนตารางนัดหมายของ User</p>

<h2><a href="getbrowserstats/fromDate/toDate" target="_blank">getbrowserstats/fromDate/toDate</a></h2>

<p>ใช้ดึงข้อมูล Stats ตาม Browser </p>

<h2><a href="getosstats/fromDate/toDate" target="_blank">getosstats/fromDate/toDate</a></h2>

<p>ใช้ดึงข้อมูล Stats ตาม OS</p>

<h2><a href="getbrowserstats/fromDate/toDate" target="_blank">getbrowserstats/fromDate/toDate</a></h2>

<p>ใช้ดึงข้อมูล Stats ตาม Browser </p>

<h2><a href="gettotalstats/fromDate/toDate" target="_blank">gettotalstats/:fromDate/:toDate</a></h2>

<p>ใช้ดึงข้อมูล Stats ตามวันที่ </p>

<h2><a href="getemployeestats/fromDate/toDate" target="_blank">getemployeestats/fromDate/toDate</a></h2>

<p>ใช้ดึงข้อมูล Employee Stats ตามวันที่ </p>

</body>
</html>