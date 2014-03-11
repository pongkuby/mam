<?php
include_once('database.php');
/**
 * Created by Thammarak
 * Date: 30/5/2556
 * Time: 22:06 น.
 */

/**เป็น Class ที่ใช้จัดการวันหยุด*/
class Holiday
{
    /**ปี*/
    public $year;
    /**เดือน*/
    public $month;
    /**วันที่*/
    public $day;
    /**ชื่อวันหยุด*/
    public $title;
    /**ประเภทของวันหยุด*/
    public $hdType;

    /**Return Array ของวันหยุด*/
    public static function getHolidays($year, $month)
    {
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM holiday h
            WHERE h.hd_year='9999' OR (h.hd_year = :year AND h.hd_month=:month) ");
        $query->bindParam(":year", $year);
        $query->bindParam(":month", $month);
        $query->execute();
        $holidays = new ArrayObject();
        while ($row = $query->fetch()) {
            $holiday = Holiday::mapData($row);
            $holidays->append($holiday);
        }
        return $holidays->getArrayCopy();
    }

    /** Map Data จาก Table เป็น Object*/
    private static function mapData($row)
    {
        if (!$row) {
            return false;
        }
        $holiday = new Holiday();
        $holiday->hdType = $row["hd_type"];
        $holiday->name = $row["hd_name"];
        $holiday->year = $row["hd_year"];
        $holiday->month = $row["hd_month"];
        $holiday->day = $row["hd_day"];
        return $holiday;
    }
}