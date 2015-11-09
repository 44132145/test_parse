<?php
trait dateTrait
{
    /** if date2 > date1 return true else false
     * date format Y-m-d / Y-m-d H:i:s
     */
    protected function Date2MoreDate1($date1, $date2)
    {
        $StartDT = new DateTime($date1, new DateTimeZone('Pacific/Nauru'));
        $EndDT = new DateTime($date2, new DateTimeZone('Pacific/Nauru'));

        if ($EndDT->diff($StartDT)->invert != 0)
            return true;
        else
            return false;
    }

    protected function checkDate(&$date)
    {
        $DateArr = array_map('intval', explode('-', $date));

        return checkdate($DateArr[1], $DateArr[2], $DateArr[0]);
    }

    protected function checkTime(&$time)
    {
        $timeArr = $DateArr = array_map('intval', explode(':', $time));

        if ((($timeArr[0] >= 0) && ($timeArr[0] < 24))
            &&  (($timeArr[1] >= 0) && ($timeArr[1] < 60))
            &&  (($timeArr[2] >= 0) && ($timeArr[2] < 60)))
            return true;
        else
            return false;
    }
}
?>