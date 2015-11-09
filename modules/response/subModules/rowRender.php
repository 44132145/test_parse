<?php
class rowRender extends AbstractRender
{
    protected function PrintData()
    {
        $DataArr = $this->initOBJ->GetArrayResult();
        $keys = $this->initOBJ->GetRowKeys();
        $str = '';
        $Rstr = '';

        $this->InitRow($DataArr,$keys, $str, $Rstr);

        print substr($str, 0, -3);
        print "<hr>" . substr($Rstr, 0, -3);
    }

    private function InitRow(&$DataArr, &$keys, &$str, &$Rstr)
    {
        foreach ($DataArr as $key => $val)
        {
            if (is_array($val)){
                if ((is_int($key)) || ((is_string($key)) && (in_array($key, $keys))))
                    $this->InitRow($val, $keys, $str, $Rstr);
            }
            else{
                if (in_array($key,$keys)){
                    $str .= $val."-->";
                    $Rstr = $val."<--".$Rstr;
                }
            }
        }
    }
}
?>