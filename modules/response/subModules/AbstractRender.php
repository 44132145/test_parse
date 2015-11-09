<?php
abstract class AbstractRender
{
    protected $initOBJ =  null;

    function __construct($initiator)
    {
        $this->initOBJ = $initiator;
    }

    abstract protected function PrintData();
}
?>