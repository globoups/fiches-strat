<?php
require_once("ErrorCode.php");
require_once("ResponseStatus.php");
require_once("Service.php");

class CardService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    public function saveCard($data)
    {
        if ($this->user->isAuthenticated) {
            $card = json_decode($data);
        
            if ($this->data->updateCard($card, $this->user)) {
                $this->response->status = ResponseStatus::SUCCESS;
            }
            else {
                $this->response->status = ResponseStatus::ERROR;
                $this->response->errorCode = ErrorCode::UNKNOWN;
            }
        }
        else {
            $this->response->status = ResponseStatus::ERROR;
            $this->response->errorCode = ErrorCode::NOT_AUTHENTICATED;
        }
    }
}
?>