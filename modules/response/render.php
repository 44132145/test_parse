<?php
require __DIR__.'/subModules/AbstractRender.php';
require __DIR__.'/subModules/jsonRender.php';
require __DIR__.'/subModules/rowRender.php';
require __DIR__.'/subModules/dumpRender.php';


class render extends AbstractRender
{
    protected $render = null;

    public function __construct(baseview $initiator)
    {
        if ($initiator instanceof jsonview)
            $this->render = new jsonRender($initiator);
        if (($initiator instanceof rowview))// && ($this->render === null)
            $this->render = new rowRender($initiator);

        // as default
        if ($this->render === null)
            $this->render = new dumpRender($initiator);

        $this->PrintData();
    }

    protected function PrintData()
    {
        $this->render->PrintData();
    }
}
?>