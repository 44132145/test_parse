<?php
/** task 1 */
if ( !class_exists('dataParser') )
    require __DIR__ . "/../parser/dataParser.php";
if ( !interface_exists('EndPoint') )
    require __DIR__ . '/interface/EndPoint.php';
if ( !trait_exists('dateTrait') )
    require __DIR__ . '/traits/dateTrait.php';
if ( !interface_exists('baseview') )
    require __DIR__ . '/../response/interfaces/baseview.php';
if ( !interface_exists('jsonview') )
    require __DIR__ . '/../response/interfaces/jsonview.php';

class pointModule implements EndPoint, baseview, jsonview
{
    use dateTrait;

    protected $parser = null;
    protected $dataArray = [];

    private $baseKay = 'AirSegments';
    private $endPointKey = 'Arrival';

    private $EndPoint = null;

    function __construct($data = null, $time = null)
    {
        $this->parser = $dataObj = dataParser::init();
        $this->dataArray = ($dataObj->GetDataAsArray()[$this->baseKay]);

        if(($data !== null) && ($time !== null))
            $this->SetSelfPoint($this->GetPointByDate($data, $time));
    }

    /** date::str[Y-m-d] time::str[H:i:s]
     *  null - not found
     *  false - error date/time
     */
    public function GetPointByDate($data, $time)
    {
        if (($this->checkDate($data)) && ($this->checkTime($time)) && (!empty($this->dataArray)) && (is_array($this->dataArray))){
            for(reset($this->dataArray); (list($key, $val) = each($this->dataArray)) !== false; )
            {
                if (($val['Arrival']['Date'] == $data) && ($val['Arrival']['Time'] == $time)){
                    $this->SetSelfPoint($val);
                    return $val;
                }
            }
            return null;
        }
        else
            return false;
    }

    public function GetLastError()
    {
        if($this->parser !== null)
            return $this->parser->GetLastError();
        else
            return ['code' => 1275, 'text' => 'Parser not defined' ];
    }

    protected function SetSelfPoint($point)
    {
        $this->EndPoint = $point;
    }

    public function GetResultData()
    {
        return $this->EndPoint;
    }

    public function GetArrayResult()
    {
        return $this->GetResultData();
    }
}

?>