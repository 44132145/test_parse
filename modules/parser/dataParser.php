<?php
if ( !class_exists('baseParser') )
    require  __DIR__."/abstract/baseParser.php";
if ( !interface_exists('parser') )
    require  __DIR__."/interface/parser.php";
if ( !trait_exists('errors') )
    require  __DIR__."/traits/errors.php";
if ( !trait_exists('singleton') )
    require  __DIR__."/traits/singleton.php";
if ( !class_exists('simpleParser') )
    require  __DIR__."/baseParser/simpleParser.php";

class dataParser extends baseParser implements parser
{
    use singleton;
    use errors;

    private $defaultFile = '057-6776453695.xml';
    private $textData = false;

    public function SetNewDataFile($fileName = null)
    {
        $Dfile = (($fileName === null)? $this->basePath.$this->defaultFile: ((strstr($fileName,'/') || strstr($fileName,'\\'))? '': $this->basePath) . $fileName);

        if ($this->CheckDataFile($Dfile)){
            $this->currentDataFileName = $Dfile;
            $this->ParseData();
        }
        else
            return false;

        return true;
    }

    public function GetDataAsArray()
    {
        if ($this->data)
        {
            $resArray = [];
            $baseE = 'zero';

            $this->ObjectToArray($this->data, $resArray, $baseE);

            return $resArray;
        }
        else
            return [];
    }

    public function GetDataAsObject()
    {
        return $this->data;
    }

    public function GetType()
    {
        return $this->type;
    }

    public function GetDataText()
    {
        return $this->textData;
    }

    protected function SetType($type = null)
    {
        if ($type === null)
            $type = $this->DEFAULT_TYPE;

        if (in_array($type, $this->OPEN_TYPES))
            $this->type = $type;
        else{
            $this->SetError(1421, 'Use undefined type of document ' . $type);
            $this->type = null;
            return false;
        }

        return true;
    }

    protected function ParseData()
    {
        if (!$this->currentDataFileName){
            $this->SetNewDataFile();
            if (!$this->currentDataFileName)
                return false;
        }

        $this->textData = file_get_contents($this->currentDataFileName);
        return $this->GetData();
    }

    protected function CheckDataFile(&$fileNamePath)
    {
        if (file_exists($fileNamePath))
            return true;
        else
            $this->SetError(404, 'File not exists: ' . $fileNamePath);
        return false;
    }

    protected function GetData()
    {
        $smolP = new smplPaese($this);
        $this->data = $smolP->GetDataObj();

        if ((is_object($this->data)) && (!empty($this->data)))
            return true;
        else
            return false;
    }

    private function ObjectToArray(&$elem, &$ResArray, &$keyName)
    {
        foreach ($elem as $key => $val)
        {
            if (!is_object($val)){
                if (preg_match('/\w/',$val))
                    if ($key == 'value')
                        $ResArray = $val;
                    else
                        $ResArray[$key] = $val;
            }
            else{
                $child = get_object_vars($val);
                $this->ObjectToArray($child, $ResArray[$key], $key);
            }
        }
    }
}
?>