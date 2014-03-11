<?php
/**
 * ใช้จัดการกับ Problem
 * Created by PhpStorm.
 * User: Thammarak
 * Date: 27/2/2557
 * Time: 15:15 น.
 */
include_once 'database.php';
include_once 'MamUtil.php';

class Problem
{
    public $problemId;
    public $empId;
    public $fullName;
    public $title;
    public $detail;
    public $lastUpdate;
    public $isFixed;

    /**Insert Problem*/
    public function insert()
    {
        $this->isFixed = MamUtil::boolToChar(false);
        $this->lastUpdate = date("Y-m-d H:i:s");
        $db = Database::getPDO();
        $query = $db->prepare("INSERT INTO problem(
            emp_id,
            title,
            detail,
            lastupdate,
            isfixed)
            VALUES(
                :emp_id,
                :title,
                :detail,
                :lastupdate,
                :isfixed)");
        $query->bindParam(":emp_id", $this->empId);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":detail", $this->detail);
        $query->bindParam(":lastupdate", $this->lastUpdate);
        $query->bindParam(":isfixed", $this->isFixed);
        $result = $query->execute();
        $this->problemId = $db->lastInsertId();
        return $result;
    }

    /** ดึงปัญหาการใช้งานทั้งหมด */
    public static function  getAll()
    {
        $result = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("select * from problem p inner join employee e on p.emp_id = e.emp_id");
        $query->execute();
        while ($row = $query->fetch()) {
            $app = Problem::mapData($row);
            $result->append($app);
        }
        if ($result->count() > 0) {
            return $result->getArrayCopy();
        } else {
            return $result;
        }
    }

    /**Map ข้อมูลเข้า Object*/
    private static function mapData($data)
    {
        if ($data == null) {
            return;
        }
        $item = new Problem();
        $item->problemId = $data["prob_id"];
        $item->empId = $data["emp_id"];
        $item->fullName = $data["first_name"] + " " + $data["last_name"];
        $item->title = $data["title"];
        $item->detail = $data["detail"];
        $item->lastUpdate = $data["lastupdate"];
        $item->isFixed = $data["isfixed"];
    }
} 