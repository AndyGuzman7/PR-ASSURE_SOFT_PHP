<?php
require_once '../parser_interface.php';
require_once 'driver.php';

class DriverParser implements Parser {
    public function parse($json) {
        return new Driver(
            0,
            $json['fullname'],
            $json['cellphone'],
            $json['license'],
            $json['ci'],
            $json['picture'],
            $json['ownerId'],
            1
        );
    }

    public function parseUpdate($json) {
        return new Driver(
            $json['id'],
            $json['fullname'],
            $json['cellphone'],
            $json['license'],          
            $json['ci'],
            $json['picture'],
            0
        );
    }
}