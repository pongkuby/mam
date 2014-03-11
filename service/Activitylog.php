<?php
/**
 * Created by Thammarak
 * Date: 14/1/2557
 * Time: 8:05 น.
 * ใช้เก็บ Activity Log
 */
include_once 'database.php';
include_once 'MamUtil.php';
class Activitylog
{
    /**Employee Id*/
    public $empId;
    /**ลง Log Date Time*/
    public $activityTime;
    /**Text ที่จะลง Log*/
    public $activityText;
    /**Resolution ของหน้าจอ*/
    public $resolution;
    /**Browser ที่ใช้*/
    public $browser;
    /**ระบบปฏิบัติการ*/
    public $system;

    /**
     * ลง Log
     */


    public static function getOS($userAgent)
    {
        // Create list of operating systems with operating system name as array key
        $oses = array(
            'iPhone' => '(iPhone)',
            'Windows 3.11' => 'Win16',
            'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // Use regular expressions as value to identify operating system
            'Windows 98' => '(Windows 98)|(Win98)',
            'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
            'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
            'Windows 2003' => '(Windows NT 5.2)',
            'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
            'Windows 7' => '(Windows NT 6.1)|(Windows 7)',

            'Windows 8' => '(Windows NT 6.2)|(Windows 7)',
            'Windows 8.1' => '(Windows NT 6.3)|(Windows 7)',

            'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
            'Windows ME' => 'Windows ME',
            'Open BSD' => 'OpenBSD',
            'Sun OS' => 'SunOS',

            'Ubuntu' => '(ubuntu)',
            'iPhone' => '(iphone)',
            'iPod' => '(ipod)',
            'iPad' => '(ipad)',
            'Android' => '(android)',
            'Macintosh' => '(Mac_PowerPC)|(Macintosh)',
            'QNX' => 'QNX',
            'BeOS' => 'BeOS',
            'OS/2' => 'OS/2',
            'Search Bot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
        );

        foreach ($oses as $os => $pattern) { // Loop through $oses array
            // Use regular expressions to check operating system type
            if (preg_match("/" . $pattern . "/i", $userAgent)) {
                return $os; // Operating system was matched so return $oses key
            }
        }
        return $userAgent; // Cannot find operating system so return Unknown
    }


    public static function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = $_SERVER['HTTP_USER_AGENT'];
        $version = "";

        // Get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $bname = 'Trident';
            $ub = "Trident";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
		} elseif (preg_match('/AppleWebKit/i', $u_agent)) {
            $bname = 'AppleWebKit';
            $ub = "AppleWebKit";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'pattern' => $pattern
        );
    }


    public static function WriteLog($empId, $message, $resolution)
    {
        $db = Database::getPDO();

        date_default_timezone_set('Asia/Bangkok');

        $ua = Activitylog::getBrowser();

        $emp_id = $empId;
        $activity_time = date("Y-m-d H:i:s");
        $activity_text = $message;
        $browser = $ua['name'] . " " . $ua['version'];
        $resolution = $resolution;
        $system = Activitylog::getOS($ua['userAgent']);
		
		$user_agent = $ua['userAgent'];
		

        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';


        $query = $db->prepare("INSERT INTO activity_log(
            emp_id,
			ipaddress,
            activity_time,
            activity_text,
            browser,
            resolution,
            system,
			user_agent) 
            VALUES('$emp_id',
			    '$ipaddress',
                '$activity_time',
                '$activity_text',
                '$browser',
				'$resolution',
                '$system',
				'$user_agent')");
        if (!$query) {
            $arr = $query->errorInfo();
            print_r($arr);
            return false;
        } else {
            $query->execute();
            return true;
        }
    }

    /**
     * Summary Activity Log แยกตาม Browser ที่ใช้
     * @param date $fromDate
     * @param date $toDate
     * @return NameValue[]
     */
    static function getTotalByBrowser($fromDate, $toDate)
    {
        $results = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("select count(*) from activity_log a
                                where a.activity_time between :fromDate and :toDate
                                into @browserCount ;
                                select browser as name,count(browser)/@browserCount*100 as value from activity_log a
                                where a.activity_time between :fromDate and :toDate
                                group by a.browser
                                order by value desc");
        $query->bindParam(":fromDate", $fromDate);
        $query->bindParam(":toDate", $toDate);
        $query->execute();
        $query->nextRowset();
        while ($row = $query->fetch()) {
            $results->append($row);
        }
        if ($results->count() > 0) {
            return $results->getArrayCopy();
        } else {
            return $results;
        }
    }

    /**
     * Summary Activity Log แยกตาม OS ที่ใช้
     * @param date $fromDate
     * @param date $toDate
     * @return NameValue[]
     */
    static function getTotalByOS($fromDate, $toDate)
    {
        $results = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("select count(*) from activity_log a
                                where a.activity_time between :fromDate and :toDate
                                into @systemCount ;

                                select system as name,count(system)/@systemCount*100 as value from activity_log a
                                where a.activity_time between :fromDate and :toDate
                                group by a.system
                                order by value desc;");
        $query->bindParam(":fromDate", $fromDate);
        $query->bindParam(":toDate", $toDate);
        $query->execute();
        $query->nextRowset();
        while ($row = $query->fetch()) {
            $results->append($row);
        }
        if ($results->count() > 0) {
            return $results->getArrayCopy();
        } else {
            return $results;
        }
    }

    /**
     * Summary Activity Log แยกตามวันที่
     * @param date $fromDate
     * @param date $toDate
     * @return NameValue[]
     */
    static function getTotalByDate($fromDate, $toDate)
    {
        $results = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("select date(a.activity_time) as name,count(distinct emp_id) as value from activity_log a
                                where a.activity_time between :fromDate and :toDate
                                group by date(a.activity_time)
                                order by date(a.activity_time);");
        $query->bindParam(":fromDate", $fromDate);
        $query->bindParam(":toDate", $toDate);
        $query->execute();
        while ($row = $query->fetch()) {
            $results->append($row);
        }
        if ($results->count() > 0) {
            return $results->getArrayCopy();
        } else {
            return $results;
        }
    }

    /**
     * Summary Activity Log ของ Employee แยกตามวันที่
     * @param date $fromDate
     * @param date $toDate
     * @return ActivityLog[]
     */
    static function getActivityLogByDate($fromDate, $toDate)
    {
        $results = new ArrayObject();
        $db = Database::getPDO();
        $query = $db->prepare("select a.activity_time, a.activity_text, a.ipaddress, a.emp_id,e.first_name,e.last_name from activity_log a
                                inner join employee e on a.emp_id = e.emp_id
                                where a.activity_time between :fromDate and :toDate
                                order by date(a.activity_time);");
        $query->bindParam(":fromDate", $fromDate);
        $query->bindParam(":toDate", $toDate);
        $query->execute();
        while ($row = $query->fetch()) {
            $results->append($row);
        }
        if ($results->count() > 0) {
            return $results->getArrayCopy();
        } else {
            return $results;
        }
    }
} 