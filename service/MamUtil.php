<?php
/**
 * Created by
 * User: Thammarak
 * Date: 12/5/2556
 * Time: 15:32 น.
 * To change this template use File | Settings | File Templates.
 */

/*เป็น Utility Class*/
class MamUtil
{
    /**Convert boolean to charactor flag*/
    static function boolToChar($value)
    {
        if ($value == true) {
            return "Y";
        } else {
            return "N";
        }
    }

    /**Convert charactor flag to boolean*/
    static function charToBool($value)
    {
        if ($value == "Y") {
            return true;
        } else {
            return false;
        }
    }

    /** Return Current DateTime*/
    static function getCurrentDateTime()
    {
        return date("Y-m-d H:i:s");
    }

    /**
     * Convert string to Date
     * @param string $value
     * @return date
     */
    static function stringToDate($value)
    {
        return date('Y-m-d', strtotime($value));
    }
}