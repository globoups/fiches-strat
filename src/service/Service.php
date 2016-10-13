<?php
require_once(dirname(__FILE__) . "/../session.php");
require_once(dirname(__FILE__) . "/../data/ModelDataManager.php");

class Service
{
    protected $data = null;
    protected $user = null;
    
    public function __construct()
    {
        $this->data = new ModelDataManager();
        $this->initializeUser();
        header('Content-type:application/json;charset=utf-8');
    }

    private function initializeUser()
    {
        $this->user = new User();

        if (isset($_SESSION["isUserAuthenticated"])) {
            $this->user->isAuthenticated = $_SESSION["isUserAuthenticated"];
        }

        if (isset($_SESSION["username"])) {
            $this->user->name = $_SESSION["username"];
        }
    }
}
?>