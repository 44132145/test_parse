<?php
class dumpRender extends AbstractRender
{
    protected function PrintData()
    {
        print "<pre>";
        var_dump($this->initOBJ->GetResultData());
        print "</pre>";

        die();
    }
}
?>