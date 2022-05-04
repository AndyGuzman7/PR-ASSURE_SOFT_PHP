<?php
require_once '../parser_interface.php';
require_once 'owner.php';

class OwnerParser implements Parser {
    public function parse($json) {
        return new Owner(
            null,
            $json['fullName'],
            $json['cellphone'],
            $json['email'],
            $json['password'],
            $json['address'],
            $json['ci'],
            $json['companyid'],
            1
        );
    }
}
