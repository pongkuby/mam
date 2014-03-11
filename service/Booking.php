<?php
/**
 * Created by Thammarak
 * Date: 29/8/2556
 * Time: 7:09 น.
 * เก็บข้อมูลการจองห้องประชุม
 */
include_once 'database.php';

class Booking
{
    public $bookId;
    public $subject;
    public $bookDate;
    public $startTime;
    public $endTime;
    public $room;
    public $roomId;
    public $bookBy;
    public $totalPeople;

    /**ดึงตารางจองห้องประชุมรายปี*/
    public static function getBookingRoomByMonth($fromDate)
    {
        $items = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM meeting m
                             WHERE m.m_startdate>=:fromDate AND year(m.m_startdate)=:year");
        $dt = date_format($fromDate, "Y-m-d");
        $year = date_format($fromDate, "Y");
        $query->bindParam(":fromDate", $dt);
        $query->bindParam(":year", $year);
        $query->execute();
        while ($row = $query->fetch()) {
            $items->append(Booking::mapData($row));
        }
        if ($items->count() > 0) {
            return $items->getArrayCopy();
        } else {
            return $items;
        }
    }

    private static function  mapData($data)
    {
        if ($data == null) {
            return;
        }
        $item = new Booking();
        $item->bookId = $data["meeting_id"];
        $item->subject = $data["m_subject"];
        $item->bookDate = $data["m_startdate"];
        $item->startTime = str_replace(".", ":", $data["m_starttime"]);
        $item->endTime = str_replace(".", ":", $data["m_endtime"]);
        $item->room = $data["m_roomname"];
        return $item;
    }
}