<?php
class CarReport implements JsonSerializable {
    public $id;
    public $calification;
    public $coments;
    public $dateTime;
    public $clientUserId;
    public $vehicleId;

    public function __construct($id = null, $calification, $coments, $dateTime,  $clientUserId, $vehicleId = null) {
        $this->id = $id;
        $this->calification = $calification;
        $this->coments = $coments;
        $this->dateTime = $dateTime;
        $this->clientUserId = $clientUserId;
        $this->vehicleId = $vehicleId;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'calification' => $this->calification,
            'comment' => $this->coments,
            'createdAt' => $this->dateTime,
            'clientUserId' => $this->clientUserId,
            'vehicleId' => $this->vehicleId
        ];
    }
}