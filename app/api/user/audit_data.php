<?php
/**
 * @author Yhonattan David Llanos Rivera
 */
abstract class AuditData {
    private $registerData;
    private $updateData;
    private $status;
    
    public function __construct($registerData="2021-9-25", $updateData="2021-9-25", $status = 1){
        $this->registerData = $registerData;
        $this->updateData = $updateData;
        $this->status = $status;
    }
    
    public function GetRegisterData(){
        return $this->registerData;
    }

    public function SetRegisterData($registerData){
        $this->registerData = $registerData;
    }

    public function GetUpdateDate(){
        return $this->updateData;
    }

    public function SetUpdateDate($updateData){
        $this->updateData = $updateData;
    }

    public function GetStatus(){
        return $this->status;
    }

    public function SetStatus($status){
        $this->status = $status;
    }
}

