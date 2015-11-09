<?php
abstract class baseParser
{
    protected $DEFAULT_TYPE = 'xml';
    protected $OPEN_TYPES = ['xml', 'json', 'oter'];

    protected $basePath = './data/';
    protected $data = null;
    protected $type = 'undefined';
    protected $currentDataFileName = null;

    abstract protected function GetData();
    abstract protected function ParseData();
    abstract protected function CheckDataFile(&$fileNamePath);
    abstract protected function SetError($number = null, $text = null);
    abstract protected function SetType();
}

?>