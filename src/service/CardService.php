<?php
require_once("Service.php");

class CardService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    public function saveCard($data)
    {
        $card = json_decode($data);
        $this->data->updateCard($card, $this->user);
    }
}
?>