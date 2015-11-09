<?php
trait singleton
{
    static private $base = null;
    /*object create once on create second exit with error header
    function __construct()
    {
            if (self::$base === null){
                self::$base = $this;
                $this->SetType();
            }
            else{
                ob_start();
                ob_get_clean();
                die(header('HTTP/1.0 423 Object already exist'));
            }
      }*/

    static public function init($type = null)
    {
        if (self::$base === null){
            $class = get_called_class();
            self::$base = new $class($type);
            return self::$base;
        }
        else
            return self::$base;
    }

    private function __construct(&$type)
    {
        $this->SetType($type);
        $this->SetNewDataFile();
    }

    private function __clone()
    {
        return self::$base;
    }
}
?>