<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
require 'Slim/Middleware/JsonApiMiddleware.php';
require 'Slim/Middleware/JsonApiView.php';
include_once "database.php";
include_once "Employee.php";
include_once "SHARE_STATUS.php";
include_once "Appointment.php";
include_once "MamUtil.php";
include_once "Login.php";
include_once "Activitylog.php";
include_once "Problem.php";

$app = new \Slim\Slim();
/*$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());*/

$app->get(
    '/',
    function () {
        include('manual.php');
        exit;
    }
);

/*================= Employee =================*/
/**check login*/
$app->get(
    '/login/:empId/:pass', function ($empId, $pass) {
        $employee = Login::getLogin($empId, $pass);
        if ($employee != null) {
            echoJSONP(array("success" => true, "result" => array($employee)));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** Search Employee โดยใช้ชื่อ*/
$app->get(
    '/getemployee/:empId', function ($empId) {
        $employee = Employee::getEmployeeById($empId);
        if (count($employee) > 0) {
            echoJSONP(array("success" => true, "employees" => array($employee)));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** Search Employee โดยใช้ชื่อ*/
$app->get(
    '/getemployees/:name', function ($name) {
        $employees = Employee::getEmployeesByName($name);
        if (count($employees) > 0) {
            echoJSONP(array("success" => true, "employees" => $employees));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);
/** Search Employee ทั้งหมด*/
$app->get(
    '/getallemployee', function () {
        $employees = Employee::getAllEmployee();
        if (count($employees) > 0) {
            echoJSONP(array("success" => true, "employees" => $employees));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/*================ ตารางนัดหมาย =================*/
/** ดึงตารางนัดหมายของ Employee*/
$app->get(
    '/getappointments/:empid/:year/:month', function ($empid, $year, $month) {
        $apps = Appointment::getEmployeeAppointment($empid, $year, $month);
        if (count($apps) > 0) {
            echoJSONP(array("success" => true, "appointments" => $apps));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** ดึงตารางนัดหมายของ Employee โดยใช้ปี*/
$app->get(
    '/getappointments/:empid/:year/excludemonth/:excludemonth', function ($empid, $year, $excludemonth) {
        $apps = Appointment::getEmployeeAppointmentByYear($empid, $year);
        if (count($apps) > 0) {
            echoJSONP(array("success" => true, "appointments" => $apps));
        } else {
            echoJSONP(array("success" => false));
        }

    }
);

/** Count ตารางนัดหมายของ Employee ทั้งปี*/
$app->get(
    '/countappointments/:empid/:year', function ($empid, $year) {
        $apps = Appointment::getEmployeeAppointmentByYear($empid, $year);
        if (count($apps) > 0) {
            echoJSONP(array("success" => true, "total_appointments" => count($apps)));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** ดึงตารางนัดหมายโดยใช้ id*/
$app->get(
    '/getappointment/:appid', function ($appid) {
        $app = Appointment::getAppointment($appid);
        if ($app != null) {
            echoJSONP(array("success" => true, "appointment" => $app));

        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** ดึงตารางนัดหมายโดยใช้ Keyword*/
$app->get(
    '/getappointments/:empid/:keyword', function ($empid, $keyword) {
        $apps = Appointment::findEmployeeAppointment($empid, $keyword);
        if (count($apps) > 0) {
            echoJSONP(array("success" => true, "appointments" => $apps));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** view ตารางนัดหมายของ employee */
$app->get(
    '/viewappointments/:empid/:year/:month/:viewerid', function ($empid, $year, $month, $viewerid) {
        $apps = Appointment::viewEmployeeAppointments($empid, $year, $month, $viewerid);
        if (count($apps) > 0) {
            echoJSONP(array("success" => true, "appointments" => $apps));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** view ตารางนัดหมายของ employee */
$app->get(
    '/getdailyappointments/:empid/:getdate', function ($empid, $getdate) {
        $apps = Appointment::getEmployeeAppointmentByDate($empid, date_create($getdate));
        if (count($apps) > 0) {
            echoJSONP(array("success" => true, "appointments" => $apps));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** view ตารางนัดหมายของ employee รายปี */
$app->get(
    '/viewappointments/:empid/:year/:viewerid/excludemonth/:excludemonth', function ($empid, $year, $viewerid, $excludemonth) {
        $apps = Appointment::viewEmployeeAppointmentsByYear($empid, $year, $viewerid, $excludemonth);
        if (count($apps) > 0) {
            echoJSONP(array("success" => true, "appointments" => $apps));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** return วันที่ update ล่าสุดของตารางนัด */
$app->get(
    '/getlastmodifieddate/:empid', function ($empid) {
        $modifiedDate = Appointment::getLastModifiedDate($empid);
        if ($modifiedDate != null) {
            echoJSONP(array("success" => true, "data" => array("modifiedDate" => $modifiedDate,
                "empId" => $empid)));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** ดึงข้อมูลวันหยุด*/
$app->get(
    '/getholidays/:year/:month', function ($year, $month) {
        $rows = Holiday::getHolidays($year, $month);
        if ($rows != null) {
            echoJSONP(array("success" => true, "holidays" => $rows));

        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** สร้างตารางนัดหมาย*/
$app->post('/postappointment', function () use ($app) {
    $request = $app->request();
    $values = $request->post();
    $appointment = new Appointment();
    $appointment = mapRequestToAppointment($appointment, $values);
    if ($appointment->insert()) {
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
        echoJSONP(array("success" => true, "appointment" => $appointment));
    } else {
        echo json_decode(array("success" => false, "appointment" => null));
    }
});

/** Update ตารางนัดหมาย*/
$app->put('/putappointment', function () use ($app) {
    $request = $app->request();
    $values = $request->post();
    $appointment = Appointment::getAppointment($values["appId"]);
    if ($appointment == null) {
        echoJSONP(array("success" => false,
            "message" => "app id not found."));
        return;
    }
    $appointment = mapRequestToAppointment($appointment, $values);
    if ($appointment->update()) {
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
        echoJSONP(array("success" => true, "appointment" => $appointment));
    } else {
        echo json_decode(array("success" => false, "appointment" => null));
    }
});

/** ลบตารางนัดหมาย*/
$app->delete(
    '/deleteappointment/:appid', function ($appid) {
        if (Appointment::deleteAppointment($appid)) {
            echoJSONP(array("success" => true));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);


/** ลบไฟล์ประกอบ Appointment โดยใช้ชื่อไฟล์ */
$app->get(
    '/delete_file_app/:filename', function ($filename) {

        if (file_exists("../resources/upload/$filename")) {
            unlink("../resources/upload/$filename");
            echoJSONP(array("success" => true));
        } else {
            echoJSONP(array("success" => false));
        }

    }
);

/** ใช้ Test connection มาที่ Server*/
$app->get(
    '/test', function () {
        echoJSONP(array("success" => true));
    }
);

/** ใช้ลง Log*/
$app->get(
    '/log/:empId/:message/:resolution', function ($empId, $message, $resolution) {
        Activitylog::WriteLog($empId, $message, $resolution);
        echoJSONP(array("success" => true));
    }
);

/** ใช้ดึงตารางจองห้องประชุมกปน. โดยใช้เดือนและปี*/
$app->get(
    '/getbookingroombymonth/:fromDate', function ($fromDate) {
        $data = Booking::getBookingRoomByMonth(date_create($fromDate));
        if (count($data) > 0) {
            echoJSONP(array("success" => true, "bookingrooms" => $data));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** ดึงตารางนัดหมายที่จะต้องมีการแจ้งเตือน User*/
$app->get(
    '/getappointmentalert/:empid/:alertdate', function ($empid, $alertdate) {
        $data = Appointment::getAppointmentAlert($empid, $alertdate);
        if (count($data) > 0) {
            echoJSONP(array("success" => true, "appointments" => $data));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** Mark ตารางนัดหมายที่จะต้องมีการแจ้งเตือน User*/
$app->get(
    '/markappointmentalert/:empid/:datesaparate', function ($empid, $datesaparate) {
        $data = Appointment::getAppointmentAlert($empid, $datesaparate);
        if (count($data) > 0) {
            echoJSONP(array("success" => true, "appointments" => $data));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** ใช้ดึงข้อมูล Stats ตาม Browser */
$app->get(
    '/getbrowserstats/:fromDate/:toDate', function ($fromDate, $toDate) {
        $data = ActivityLog::getTotalByBrowser(MamUtil::stringToDate($fromDate), MamUtil::stringToDate($toDate));
        if (count($data) > 0) {
            echoJSONP(array("success" => true, "data" => $data));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** ใช้ดึงข้อมูล Stats ตาม OS */
$app->get(
    '/getosstats/:fromDate/:toDate', function ($fromDate, $toDate) {
        $data = ActivityLog::getTotalByOS(MamUtil::stringToDate($fromDate), MamUtil::stringToDate($toDate));
        if (count($data) > 0) {
            echoJSONP(array("success" => true, "data" => $data));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** ใช้ดึงข้อมูล Stats ตามวันที่ */
$app->get(
    '/gettotalstats/:fromDate/:toDate', function ($fromDate, $toDate) {
        $data = ActivityLog::getTotalByDate(MamUtil::stringToDate($fromDate), MamUtil::stringToDate($toDate));
        if (count($data) > 0) {
            echoJSONP(array("success" => true, "data" => $data));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** ใช้ดึงข้อมูล Employee Stats ตามวันที่ */
$app->get(
    '/getemployeestats/:fromDate/:toDate', function ($fromDate, $toDate) {
        $data = ActivityLog::getActivityLogByDate(MamUtil::stringToDate($fromDate), MamUtil::stringToDate($toDate));
        if (count($data) > 0) {
            echoJSONP(array("success" => true, "data" => $data));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

/** สร้างปัญหาการใช้งานใหม่*/
$app->post('/problem/create', function () use ($app) {
    $request = $app->request();
    $problem = mapRequestToProblem(json_decode($request->getBody(),true));
    if ($problem->insert()) {
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
        echoJSONP(array("success" => true, "data" => $problem));
    } else {
        echoJSONP(array("success" => false, "data" => null));
    }
});

/** ใช้ดึงข้อมูล Employee Stats ตามวันที่ */
$app->get(
    '/problems/load', function ($fromDate, $toDate) {
        $data = ActivityLog::getActivityLogByDate(MamUtil::stringToDate($fromDate), MamUtil::stringToDate($toDate));
        if (count($data) > 0) {
            echoJSONP(array("success" => true, "data" => $data));
        } else {
            echoJSONP(array("success" => false));
        }
    }
);

$app->run();

/** Map request to Appointment Object*/
function mapRequestToAppointment(Appointment $app, array $values)
{
    $app->appId = $values["appId"];
    $app->appType = $values["appType"];
    $app->event = $values['event'];
    $app->title = $values["title"];
    $app->place = $values["place"];
    $app->detail = $values["detail"];
    $app->start = $values["start"];
    $app->end = $values["end"];
    $app->isAllDay = $values["isAllDay"];
    $app->owners = $values["owners"];
    $app->shareStatusId = $values["shareStatusId"];
    $app->shareEmployees = $values["shareEmployees"];
    $app->modifiedDate = MamUtil::getCurrentDateTime();
    return $app;
}

/** Map request to Appointment Object*/
function echoJSONP(array $data)
{
    $callback = $_REQUEST['callback'];
    if ($callback) {
        header('Content-Type: text/javascript');
        echo $callback . '(' . json_encode($data) . ');';
    } else {
        header('Content-Type: application/x-json');
        echo json_encode($data);
    }
}

function mapRequestToProblem(array $values)
{
    $data = new Problem();
    $data->title = $values["title"];
    $data->detail = $values["detail"];
    $data->empId = $values["empId"];
    return $data;
}