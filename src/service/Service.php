<?php
require_once(dirname(__FILE__) . "/../session.php");
require_once(dirname(__FILE__) . "/../data/ModelDataManager.php");

class Session
{
    protected $data = null;
    
    public function __construct()
    {
        $this->data = new ModelDataManager();
        header('Content-type:application/json;charset=utf-8');
    }
}
?>