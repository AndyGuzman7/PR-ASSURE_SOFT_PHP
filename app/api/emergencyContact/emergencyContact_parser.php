<?php
require_once '../parser_interface.php';
require_once 'emergencyContact.php';

class EmergencyContactParser implements Parser{
    public function parse($json) {
        return new EmergencyContact(
            $json['idEmergencyContact'],
            $json['nameContact'],
            $json['number'],
            $json['idClientUser']
        );
    }
}