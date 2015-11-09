<?php
/** task 2 */
if ( !class_exists('pointModule') )
    require __DIR__ . "/pointModule.php";
if ( !interface_exists('Route') )
    require __DIR__ . '/interface/Route.php';
if ( !interface_exists('rowview') )
    require __DIR__ . '/../response/interfaces/rowview.php';


class routModule extends pointModule implements Route, baseview,rowview
{
    private $startPoint = null;
    private $endPoint = null;

    private $BetweenStartEnd = [];
    private $RoutingArr = [];

    public function getRoute($StartDate, $StartTime, $EndDate, $EndTime)
    {
        if ($this->CheckStartEndDate($StartDate, $StartTime, $EndDate, $EndTime)){
            $this->SetPoint($this->GetPointByDate($StartDate, $StartTime));
            $this->SetPoint($this->GetPointByDate($EndDate, $EndTime), 'E');

            if (($this->startPoint) && ($this->endPoint)){
                $this->GetBetweenArray();

                if ((empty($this->BetweenStartEnd)) && ($this->startPoint['Off']['Point'] == $this->endPoint['Board']['Point'])){
                    $this->RoutingArr[0] =  [$this->startPoint, $this->endPoint];
                    return $this->RoutingArr;
                }
                elseif ((empty($this->BetweenStartEnd))){
                    return null;
                }
                    else{
                         $Routing = [];
                         $this->CreateRoute($this->startPoint, $Routing);

                         for($i = 0; $i < count($Routing); $i++)
                         {
                            array_unshift($Routing[$i], $this->startPoint);
                            $Routing[$i][count($Routing[$i])] = $this->endPoint;
                         }

                         $this->RoutingArr = $Routing;

                         return $Routing;
                    }
                return false;
            }
            else
                return null;

        }
        else
            return false;
    }

    protected function CheckStartEndDate(&$StartDate, &$StartTime, &$EndDate, &$EndTime)
    {
        if (($this->checkDate($StartDate)) && ($this->checkDate($EndDate))
            && ($this->checkTime($StartTime)) && ($this->checkTime($EndTime))){
            return $this->Date2MoreDate1($StartDate . ' ' . $StartTime, $EndDate . ' ' . $EndTime);
        }
        else
            return false;
    }

    protected function SetPoint($data, $type = 'S')
    {
        if ($data)
            if ($type == 'S')
                $this->startPoint = $data;
            else
                $this->endPoint = $data;
        else
            return false;
    }

    /** get AirSegments  Between StartDate and EndDate */
    private function GetBetweenArray()
    {
        for(reset($this->dataArray); (list($key,$val)=each($this->dataArray)) !== false;)
        {
            if (($this->Date2MoreDate1($this->startPoint['Arrival']['Date'] . ' ' . $this->startPoint['Arrival']['Time'], $val['Arrival']['Date'] .' '. $val['Arrival']['Time']))
            && ($this->Date2MoreDate1($val['Arrival']['Date'] .' '. $val['Arrival']['Time'], $this->endPoint['Arrival']['Date'] . ' ' . $this->endPoint['Arrival']['Time'])))
                $this->BetweenStartEnd[] = $val;
        }
    }

    private function CreateRoute(&$CurrPoint, &$ResArr, $RoutKey = 0)
    {
        if (($nPoint=($this->GetOnePoint($CurrPoint))) !== false){
            $ResArr[$RoutKey][] = $nPoint;
            $this->CreateRoute($nPoint, $ResArr, $RoutKey);
        }elseif (($nPoint === false) && ($CurrPoint != $this->startPoint))
                $this->CreateRoute($this->startPoint, $ResArr, ($RoutKey+1));
            else
                return true;
    }

    private function GetOnePoint(&$parent)
    {
        if (!empty($this->BetweenStartEnd))
            foreach($this->BetweenStartEnd as $key => $data)
            {
                if($data['Board']['Point'] == $parent['Off']['Point']){
                    $rr = $data;
                    unset($this->BetweenStartEnd[$key]);
                    return $rr;
                }
            }
        return false;
    }

    public function GetResultData()
    {
        return $this->RoutingArr;
    }

    public function GetArrayResult()
    {
        return $this->GetResultData();
    }

    public function GetRowKeys()
    {
        return ['Board','Point'];
    }
}

?>