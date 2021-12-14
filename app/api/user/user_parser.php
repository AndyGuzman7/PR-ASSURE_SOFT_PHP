<?php
require_once '../parser_interface.php';
require_once 'user.php';
class UserParser implements Parser {
    public function parse($json) {
        return new User(
            $json["email"],
            $json["password"],
            $json["typeRegister"],
            null,
            $json["fullName"],
            $json["cellphone"],
            null,
            null,
            null
        );
    }
}
