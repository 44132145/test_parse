<?php
interface parser
{
    public function SetNewDataFile($fileName = null);

    public function GetDataAsArray();

    public function GetDataAsObject();

    public function GetType();

    public function GetLastError();

    public function GetAllErrors();

    public function GetDataText();
}
?>