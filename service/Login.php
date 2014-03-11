<?php
include_once 'database.php';


class Login
{
    /**ID �ͧ Employee*/
    public $statusLogin;

    /**�֧������ Employee ���� ID*/
    public static function getLogin($empId, $pass)
    {
        $dd = substr($pass, 0, 2);
        $mm = substr($pass, 2, 2);
        $yy = substr($pass, 4, 4) - 543;
        $encryptPass = md5($yy . "-" . $mm . "-" . $dd);

        $db = Database::getPDO();
        $query = $db->prepare("SELECT * FROM employee WHERE emp_id=:empid and passwd=:pass;");
        $query->bindParam(":empid", $empId);
        $query->bindParam(":pass", $encryptPass);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        } else {
            return Employee::mapData($data);
        }
    }
}
