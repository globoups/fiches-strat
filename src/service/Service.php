<?php
require_once("Response.php");
require_once(dirname(__FILE__) . "/../session.php");
require_once(dirname(__FILE__) . "/../data/ModelDataManager.php");

class Service
{
    protected $data = null;
    protected $response = null;
    protected $user = null;
    
    public function __construct()
    {
        $this->data = new ModelDataManager();
        $this->response = new Response();
        $this->initializeUser();
        header('Content-type:application/json;charset=utf-8');
    }

    public function printResponse() {
        echo json_encode($this->response);
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