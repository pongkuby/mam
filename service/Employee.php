<?php
include_once 'database.php';

/**
 * Created by Thammarak
 * Date: 8/5/2556
 * Time: 13:58 น.
 */
class Employee
{
    /**ID ของ Employee*/
    public $empId;
    /**ชื่อ*/
    public $firstName;
    /**นามสกุล*/
    public $lastName;
    /**Email*/
    public $email;
    /**โทรศัพท์มือถือ*/
    public $mobilePhone;
    /**โทรศัพท์*/
    public $phone;
    /**โทรศัพท์*/
    public $phoneOnly;
    /**แผนก*/
    public $division;
    /**ระดับ**/
    public $sub_group;
    /**ระดับผู้บริหาร**/
    public $ee_group;
    /*ตำแหน่ง*/
    public $position;

    /**ดึงข้อมูล Employee โดยใช้ ID*/
    public static function getEmployeeById($empId)
    {
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM employee WHERE emp_id=:empid ;");
        $query->bindParam(":empid", $empId);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        } else {
            return Employee::mapData($data);
        }
    }

    /**ค้นหา Employee */
    public static function getEmployeesByName($name)
    {
        $name = str_replace(" ", ".", $name);
        $employees = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM employee WHERE first_name like ? or last_name like ?
                                or org_text like ? or org_unit_text like?;");
        $params = array("%$name%", "%$name%", "%$name%", "%$name%");
        $query->execute($params);
        while ($row = $query->fetch()) {
            $employee = Employee:: mapData($row);
            $employees->append($employee);
        }
        if ($employees->count() > 0) {
            return $employees->getArrayCopy();
        } else {
            return $employees;
        }
    }

    /**ค้นหา Employee */
    public static function getAllEmployee()
    {
        $employees = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM employee;");
        $query->execute();
        while ($row = $query->fetch()) {
            $employee = Employee:: mapData($row);
            $employees->append($employee);
        }
        if ($employees->count() > 0) {
            return $employees->getArrayCopy();
        } else {
            return $employees;
        }
    }

    /**Return Owner ของ Appointment*/
    public static function getOwnerAppointment($appid)
    {
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment_emp a
            INNER JOIN employee e ON a.emp_id = e.emp_id
            WHERE a.app_id = :appid;");
        $query->bindParam(":appid", $appid);
        $query->execute();
        $employees = new ArrayObject();
        while ($row = $query->fetch()) {
            $employee = Employee::mapData($row);
            $employees->append($employee);
        }
        if ($employees->count() > 0) {
            return $employees->getArrayCopy();
        } else {
            return false;
        }
    }

    /**Return Viewer ของ Appointment*/
    public static function getViewerAppointment($appid)
    {
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM appointment_show a
            INNER JOIN employee e ON a.emp_id = e.emp_id
            WHERE a.app_id = :appid;");
        $query->bindParam(":appid", $appid);
        $query->execute();
        $employees = new ArrayObject();
        while ($row = $query->fetch()) {
            $employee = Employee::mapData($row);
            $employees->append($employee);
        }
        return $employees->getArrayCopy();
    }

    /** Map Data จาก Table เป็น Object*/
    public static function mapData($row)
    {
        if (!$row) {
            return false;
        }
        $employee = new Employee();
        $employee->empId = $row["emp_id"];
        $employee->firstName = $row["first_name"];
        $employee->lastName = $row["last_name"];
        $employee->email = $row["email"];
        $employee->division = $row["cctr_text"];
        $employee->position = $row["pos_name"];
        if ($row["sub_group"] >= 06) {
            $employee->mobilePhone = $row["phone"];
        }
        if (trim($row["telcenter"]) != "" && $row["telcenter"] != "-") {
            $employee->phone = substr(str_replace(" ", "", $row["telcenter"]), 0, 9);
            $employee->phoneOnly = $employee->phone;
            $employee->phone = $employee->phone . " ต่อ " . $row["ext_no"];
        } else {
            if ($row["ext_no"] != null || trim($row["ext_no"]) != "" || $row["ext_no"] != "-") {
                $employee->phoneOnly = "025040123";
                $employee->phone = $employee->phoneOnly;
                $employee->phone = $employee->phone . " ต่อ " . $row["ext_no"];
            }
            if (($row["direct_no"] != "" && $row["direct_no"] != "-")) {
                $employee->phone = substr(str_replace(" ", "", $row["direct_no"]), 0, 9);
                $employee->phoneOnly = $employee->phone;
            }
        }
        $employee->sub_group = $row["sub_group"];
        $employee->ee_group = $row["ee_group"];
        return $employee;
    }

}
