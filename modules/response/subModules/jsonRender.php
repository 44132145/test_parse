<?php
class jsonRender extends AbstractRender
{
    protected function PrintData()
    {
        $json = json_encode($this->initOBJ->GetArrayResult());
        print $json;
    }
}
?>