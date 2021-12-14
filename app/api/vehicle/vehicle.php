<?php
class Vehicle implements JsonSerializable {
    protected $idVehicle;
    protected $color;
    protected $model;
    protected $pleik;
    protected $capacity;
    protected $picture;
    protected $status;
    protected $idOwner;

    public function __construct($idVehicle, $color, $model, $pleik, $capacity, $picture, $idOwner, $status = 1) {
        $this->idVehicle = $idVehicle;
        $this->color = $color;
        $this->model = $model;   
        $this->pleik = $pleik;  
        $this->capacity = $capacity;  
        $this->picture = $picture; 
        $this->status = $status;  
        $this->idOwner = $idOwner;   
    }

    public function jsonSerialize() {
        return [
            'idVehicle' => $this->idVehicle,
            'color' => $this->color,
            'model' => $this->model,
            'pleik' => $this->pleik,
            'capacity' => $this->capacity,
            'picture' => $this->picture,
            'idOwner' => $this->idOwner,
            'status' => $this->status
        ];
    }

    public function getIdVehicle()
    {
        return $this->idVehicle;
    }
    public function setIdVehicle($idVehicle)
    {
       $this->idVehicle = $idVehicle;
    }
       
    public function getColor()
    {
        return $this->color;
    }
    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getModel()
    {
        return $this->model;
    }
    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getPleik()
    {
        return $this->pleik;
    }
    public function setPleik($pleik)
    {
        $this->pleik = $pleik;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }


    public function getPicture()
    {
        return $this->picture;
    }
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getOwnerId()
    {
        return $this->idOwner;
    }
    public function setOwnerId($idOwner)
    {
        $this->idOwner = $idOwner;
    }
}
