<?php
/**
 * Created by
 * User: Thammarak
 * Date: 8/5/2556
 * Time: 14:07 น.
 */
include_once 'database.php';
include_once 'MamUtil.php';
include_once 'APPOINTMENT_TYPE.php';
include_once 'APPOINTMENT_CSS.php';
include_once "APPROVE_STATUS.php";
include_once "Booking.php";

class Appointment
{
    /**Id ของตารางนัดหมาย*/
    public $appId;
    /** ประเภทของการนัดหมาย*/
    public $appType;
    /** เวลาที่นัดหมาย*/
    public $event;
    /** หัวข้อการนัดหมาย*/
    public $title;
    /** สถานที่*/
    public $place;
    /** รายละเอียดการนัดหมาย*/
    public $detail;
    /** เป็น True ถ้าเป็นตารางนัดหมายทั้งวัน*/
    public $isAllDay;
    /** วันที่เริ่มต้น*/
    public $start;
    /** วันที่สิ้นสุด*/
    public $end;
    /** ผู้เข้าร่วมการนัดหมาย*/
    public $owners;
    /** สถานะการ Share*/
    public $shareStatusId;
    /** Employee ที่ Share ให้เห็น */
    public $shareEmployees;
    /**ประเภทของการเตือน */
    public $reminderId;
    /**วันทีั่เริ่มต้นการเตือน*/
    public $startReminder;
    /**วันที่สิ้นสุดการเตือน*/
    public $endReminder;
    /**วันที่แก้ไขล่าสุด*/
    public $modifiedDate;
    /*
    *Css type ใช้ในการจัด Style ประกอบไปด้วย
     * holiday
     * busy
     * normal
     */
    public $css;

    public $startTime;

    public $endTime;

    /**Insert Current Appointment To Database*/
    public function insert()
    {
        $db = Database::getPDO();
        $query = $db->prepare("INSERT INTO appointment(
            'app_id',
            'app_type_id',
            'app_subject',
            'app_place',
            'app_detail',
            'app_status',
            'app_all_day',
            'app_modified_date') 
            VALUES(:app_id,
                :app_type_id,
                :app_subject,
                :app_place,
                :app_detail,
                :app_status,
                :app_all_day,
                :app_modified_date)");
        $query->bindParam(":appid", $appid);
        $query->bindParam(":app_type_id", $this->appType);
        $query->bindParam(":app_subject", $this->title);
        $query->bindParam(":app_place", $this->place);
        $query->bindParam(":app_detail", $this->detail);
        $query->bindParam(":app_status", $this->shareStatusId);
        $query->bindParam(":app_all_day"
            , MamUtil :: boolToChar($this->isAllDay));
        $query->bindParam(":app_modified_date", date("Y-m-d H:i:s"));
        return $query->execute();
    }

    /**Update Current Appointment To Database*/
    public function update()
    {
        return true;
    }

    /**Return Last update ข้อมูลตารางนัด */
    public static function getLastModifiedDate($empid)
    {
        $db = Database::getPDO();
        $query = $db->prepare("SELECT max(a.app_modified_date) as app_modified_date
                                FROM appointment a INNER JOIN appointment_emp e on a.app_id = e.app_id
                                where e.emp_id =:empid ;");
        $query->bindParam(":empid", $empid);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        } else {
            return $data["app_modified_date"];
        }
    }

    /** ดึงข้อมูล Appointment ของ Employee โดยใช้ ปี และเดือน */
    public static function  getEmployeeAppointment($empid, $year, $month)
    {
        $apps = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment a
                             INNER JOIN appointment_emp e on a.app_id = e.app_id
                             WHERE e.emp_id =:empid
                             AND month(a.app_start_date)=:month
                             AND year(a.app_start_date)=:year");
        $query->bindParam(":empid", $empid);
        $query->bindParam(":month", $month);
        $query->bindParam(":year", $year);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapData($row);
            $apps->append($app);
        }

        $query = $db->prepare("SELECT * FROM holiday h
            WHERE (h.hd_year='9999' and h.hd_month=:month) OR (h.hd_year = :year AND h.hd_month=:month) ");
        $query->bindParam(":year", $year);
        $query->bindParam(":month", $month);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapHolidayData($row, $year);
            $apps->append($app);
        }
        if ($apps->count() > 0) {
            return $apps->getArrayCopy();
        } else {
            return $apps;
        }
    }

    /** ดึงข้อมูล Appointment ของ Employee โดยใช้ ปี */
    public static function  getEmployeeAppointmentByYear($empid, $year)
    {
        $apps = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment a
                             INNER JOIN appointment_emp e on a.app_id = e.app_id
                             WHERE e.emp_id =:empid
                             AND year(a.app_start_date)>=:year");
        $query->bindParam(":empid", $empid);
        $query->bindParam(":year", $year);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapData($row);
            $apps->append($app);
        }
        $query = $db->prepare("SELECT * FROM holiday h
            WHERE (h.hd_year='9999' OR h.hd_year >= :year) ");
        if ($year > 2500) {
            $year = $year - 543;
        }
        $query->bindParam(":year", $year);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapHolidayData($row, $year);
            $apps->append($app);
        }

        /*ดึงตารางจองห้องประชุม ผ่าน Web Service*/
//        $response = file_get_contents('http://ehr.mwa.co.th/meeting/service?action=getbookingbyyear&year=' . $year);
//        $result = json_decode($response);
//        if ($result->success == true) {
//            foreach ($result->data as $item) {
//                $app = Appointment::mapBookingData($item);
//                $apps->append($app);
//            }
//        }
        /*ดึงตารางจองห้องประชุมผ่าน Database*/
        /*$result = Booking::getBookingRoomByMonth(date('m'),$year);
        foreach ($result as $item) {
            $app = Appointment::mapBookingData($item);
            $apps->append($app);
        }
        */
        if ($apps->count() > 0) {
            return $apps->getArrayCopy();
        } else {
            return $apps;
        }
    }

    /** ดึงข้อมูล Appointment ของ Employee โดยใช้วันที่ */
    public static function  getEmployeeAppointmentByDate($empid, $getDate)
    {
        $apps = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment a
                             INNER JOIN appointment_emp e on a.app_id = e.app_id
                             WHERE e.emp_id =:empid
                             AND a.app_start_date=:getDate");
        $dt = date_format($getDate, 'Y-m-d');
        $query->bindParam(":empid", $empid);
        $query->bindParam(":getDate", $dt);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapData($row);
            $apps->append($app);
        }
        $query = $db->prepare("SELECT * FROM holiday h
            WHERE (()h.hd_year='9999' OR h.hd_year >= :year)
            AND h.hd_month=:month AND h.hd_day=:day) ");
        $d = date_format($getDate, "d");
        $m = date_format($getDate, "m");
        $y = date_format($getDate, "Y");
        $query->bindParam(":year", $y);
        $query->bindParam(":month", $m);
        $query->bindParam(":day", $d);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapHolidayData($row, date_format($getDate, "Y"));
            $apps->append($app);
        }
        if ($apps->count() > 0) {
            return $apps->getArrayCopy();
        } else {
            return $apps;
        }
    }

    /** ค้นหา Appointment ของ Employee โดยใช้ Keyword */
    public static function  findEmployeeAppointment($empid, $keyword)
    {
        $apps = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment a
                            INNER JOIN appointment_emp e on a.app_id = e.app_id
                            WHERE e.emp_id = ? AND (a.app_subject LIKE ?
                            OR a.app_detail LIKE ? OR app_place LIKE ? )");
        $params = array("$empid", "%$keyword%", "%$keyword%", "%$keyword%");
        $query->execute($params);
        while ($row = $query->fetch()) {
            $app = Appointment::mapData($row);
            $apps->append($app);
        }

        $query = $db->prepare("SELECT * FROM holiday h
            WHERE (h.hd_year='9999')
            AND h.name LIKE ?");
        $params = array("%$keyword%");
        $query->execute($params);
        while ($row = $query->fetch()) {
            $app = Appointment::mapHolidayData($row, $row["hd_year"]);
            $apps->append($app);
        }
        if ($apps->count() > 0) {
            return $apps->getArrayCopy();
        } else {
            return $apps;
        }
    }

    /** ดู Appointment ของ Employee*/
    public static function  viewEmployeeAppointments($empid, $year, $month, $viewerid)
    {
        $apps = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment a
                              INNER JOIN appointment_emp e on a.app_id = e.app_id
                             WHERE e.emp_id=:empid AND month(a.app_start_date)=:month
                             AND year(a.app_start_date)>=:year");
        $query->bindParam(":empid", $empid);
        $query->bindParam(":month", $month);
        $query->bindParam(":year", $year);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapData($row);
            if ($row['app_status'] == SHARE_STATUS::BUSY) {
                $app->title = "ไม่ว่าง";
                $app->css = APPOINTMENT_CSS::BUSY;
            } else if ($row['app_status'] == SHARE_STATUS::SPECIFY) {
                if (!Appointment::canView($app->appId, $viewerid)) {
                    continue;
                }
            }
            $apps->append($app);
        }

        $query = $db->prepare("SELECT * FROM holiday h
            WHERE (h.hd_year='9999' and h.hd_month=:month) OR (h.hd_year = :year AND h.hd_month=:month) ");
        if ($year > 2500) {
            $year = $year - 543;
        }
        $query->bindParam(":year", $year);
        $query->bindParam(":month", $month);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapHolidayData($row, $year);
            $apps->append($app);
        }
        if ($apps->count() > 0) {
            return $apps->getArrayCopy();
        } else {
            return $apps;
        }
    }

    /** ดู Appointment ของ Employee*/
    public static function  viewEmployeeAppointmentsByYear($empid, $year, $viewerid, $excludemonth)
    {
        $apps = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment a
                              INNER JOIN appointment_emp e on a.app_id = e.app_id
                             WHERE e.emp_id =:empid AND year(a.app_start_date)>=:year");
        $query->bindParam(":empid", $empid);
        $query->bindParam(":year", $year);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapData($row);
            if ($row['app_status'] == SHARE_STATUS::BUSY) {
                $app->title = "ไม่ว่าง";
                $app->css = APPOINTMENT_CSS::BUSY;
            } else if ($row['app_status'] == SHARE_STATUS::SPECIFY) {
                if (!Appointment::canView($app->appId, $viewerid)) {
                    continue;
                }
            }
            $apps->append($app);
        }
        $query = $db->prepare("SELECT * FROM holiday h
            WHERE (h.hd_year='9999' OR h.hd_year >=:year) ");
        if ($year > 2500) {
            $year = $year - 543;
        }
        $query->bindParam(":year", $year);
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Appointment::mapHolidayData($row, $year);
            $apps->append($app);
        }
        if ($apps->count() > 0) {
            return $apps->getArrayCopy();
        } else {
            return $apps;
        }
    }

    /** ดึงข้อมูล Appointment โดยใช้ ID
     */
    public static function  getAppointment($appid)
    {
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment a
                            WHERE a.app_id =:appid;");
        $query->bindParam(":appid", $appid);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        } else {
            return Appointment::mapData($data);
        }
    }

    public static function deleteAppointment($appid)
    {
        $db = Database::getPDO();
        $query = $db->prepare("DELETE FROM appointment_show where app_id=:appid");
        $query->bindParam(":appid", $appid);
        $query->execute();
        $query = $db->prepare("DELETE FROM appointment_emp where app_id=:appid");
        $query->bindParam(":appid", $appid);
        $query->execute();
        $query = $db->prepare("DELETE FROM appointment where app_id=:appid");
        $query->bindParam(":appid", $appid);
        $query->execute();
        return true;
    }

    /*
    * ดึงตารางนัดหมายที่จะต้องมีการแจ้งเตือน User
     */
    public static function  getAppointmentAlert($empId, $alertDate)
    {
        $db = Database::getPDO();
        $apps = new ArrayObject();
        $query = $db->prepare("select * from appointment_alert al
                                inner join appointment a on al.app_id=a.app_id
                                where al.alert_id like ?
                                and al.alert_date like ?
                                and a.app_start_date>=? ");
        $params = array("%$empId%", "%$alertDate%","$alertDate");
        $query->execute($params);
        while ($row = $query->fetch()) {
            $app = Appointment::mapData($row);
            $apps->append($app);
        }
        if ($apps->count() > 0) {
            return $apps->getArrayCopy();
        } else {
            return $apps;
        }
    }

    /*
    * Mark ว่ามีการแจ้งเตือนไปแล้ว
     */
    public static function  markAppointmentAlert($empId, $alertDate)
    {
        $db = Database::getPDO();
    }

    /*Check ว่า view สามารถดู Appointment ได้หรือไม่*/
    private static function canView($appid, $viewerid)
    {
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment_show a
            WHERE a.app_id=:appid and a.emp_id=:viewerid ");
        $query->bindParam(":appid", $appid);
        $query->bindParam(":viewerid", $viewerid);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return false;
        } else {
            return true;
        }
    }

    /**Map Data เข้า Appointment*/
    private static function mapData($data)
    {
        if ($data == null) {
            return;
        }
        $app = new Appointment();
        $app->appId = $data["app_id"];
        $app->appType = $data["app_type_id"];
        $startTime = date("H:i", strtotime($data['app_start_time']));
        $endTime = date("H:i", strtotime($data['app_end_time']));
        $app->startTime = $startTime;
        $app->endTime = $endTime;
        $app->event = $startTime . " - " . $endTime;
        $app->start = $data['app_start_date'] . " " . $data['app_start_time'] . "";
        $app->end = $data['app_end_date'] . " " . $data['app_end_time'] . "";
        $app->isAllDay = MamUtil::charToBool($data['app_all_day']);
        $app->shareStatusId = $data['app_status'];
        $app->title = $data["app_subject"];
        $app->place = $data["app_place"];
        $app->detail = $data["app_detail"];
        switch ($data["approve_status"]) {
            case APPROVE_STATUS::READ:
                $app->css = APPOINTMENT_CSS::READ;
                break;
            case APPROVE_STATUS::UNREAD:
                $app->css = APPOINTMENT_CSS::NORMAL;
                break;
            case APPROVE_STATUS::APPROVED:
                $app->css = APPOINTMENT_CSS::APPROVED;
                break;
            case APPROVE_STATUS::REJECT:
                $app->css = APPOINTMENT_CSS::REJECT;
                break;
            default:
                $app->css = APPOINTMENT_CSS::NORMAL;
                break;
        }
        return $app;
    }

    /** Map Data จาก Table เป็น Object*/
    private static function mapHolidayData($data, $year)
    {
        if (!$data) {
            return false;
        }
        $app = new Appointment();
        $app->event = 'ทั้งวัน';
        $app->isAllDay = true;
        $app->appType = APPOINTMENT_TYPE::HOLIDAY;
        $app->title = $data["hd_name"];
        $app->start = date('Y-m-d',
                strtotime($year . '-' . $data["hd_month"] . '-' . $data["hd_day"])) . "T01:00:00Z";
        $app->end = date('Y-m-d',
                strtotime($year . '-' . $data["hd_month"] . '-' . $data["hd_day"])) . "T02:00:00Z";
        $app->css = APPOINTMENT_CSS::HOLIDAY;
        return $app;
    }

    /** Map Data จากตารางจองห้องประชุม เป็น Appointment*/
    private static function mapBookingData($data)
    {
        if (!$data) {
            return false;
        }
        $app = new Appointment();
        $app->appId = $data->bookId;
        $app->event = $data->startTime . " - " . $data->endTime;
        $app->isAllDay = false;
        $app->appType = APPOINTMENT_TYPE::BOOKING;
        $app->title = $data->subject;
        $app->start = date('Y-m-d', strtotime($data->bookDate)) . " " . $data->startTime;
        $app->end = date('Y-m-d', strtotime($data->bookDate)) . " " . $data->endTime;
        $app->place = $data->room;
        $app->detail = $data->subject . " " . $data->room . " โดย " . $data->bookBy;
        $app->css = APPOINTMENT_CSS::BOOKING;
        return $app;
    }
}
