<?php
interface EndPoint
{
    public function GetPointByDate($data, $time);

    public function GetLastError();
}
?>