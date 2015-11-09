<?php
/** some like  pattern  Bridge*/
abstract class simpleParser
{
    protected  $DataObj = null;
    abstract protected function ParseData($textData);

    function __construct($textData = null)
    {
       if ($textData !== null)
            $this->ParseData($textData);
    }
}

interface simpleParserI
{
    public function GetDataObj();
}

/** common parser class*/
class smplPaese implements simpleParserI
{
    protected  $parser = null;

    function __construct(parser $ParserObj)
    {
        switch ($ParserObj->GetType())
        {
            case 'xml':
                $this->parser = new xmlParser($ParserObj->GetDataText());
                break;
            case 'json':
                die('not defined now');
            break;
        }
    }

    public function GetDataObj()
    {
        return $this->parser->GetDataObj();
    }
}

/** XML parser */
class xmlParser extends simpleParser implements simpleParserI
{
    public function GetDataObj()
    {
        return $this->DataObj;
    }

    protected  function ParseData($textData)
    {
        $dataObj = new DOMDocument();
        $dataObj->loadXML($textData);
        $this->DataObj = new stdClass();

        $this->getNodes($dataObj->documentElement, $this->DataObj);
    }

    private function getNodes($obj, &$dataObj)
    {
        foreach ($obj->childNodes AS $item) {

            if (is_object($item)) {
                if ((is_object($item->childNodes)) ) {
                    $property = $item->nodeName;
                    $this->GetNodeName($dataObj, $property);

                    $dataObj->{$property} = new stdClass();

                    if ($item->hasAttributes())
                        foreach($item->attributes as $attr)
                            $dataObj->{$property}->{$attr->nodeName}=$attr->nodeValue;

                    $this->getNodes($item, $dataObj->{$property});
                } else{
                    if((!empty($item->nodeValue)) && ($dataObj !== null))
                        $dataObj->value = $item->nodeValue;
                }
            }
        }
    }

    private function GetNodeName(&$object, &$property, $num = 0)
    {
        $pName = $property . (($num > 0)? $num: '');

        if (property_exists($object,$pName))
            $this->GetNodeName($object, $property, ($num+1));
        else
            $property = $pName;
    }
}

?>