<?php
require_once '../parser_interface.php';
require_once 'vehicle.php';

class VehicleParser implements Parser {
    public function parse($json) {
        return new Vehicle(
            0,
            $json['color'],
            $json['model'],
            $json['pleik'],
            $json['capacity'],
            $json['picture'],
            $json['ownerId']
        );
    }
}