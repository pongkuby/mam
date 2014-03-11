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
} 