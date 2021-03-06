<?php

/**
 * Contains driver class/model to represent Driver table on database
 * @author Sofia Valeria Toro Chambi
 */


/**
 * Representation of Driver table on database
 */
class Driver implements \JsonSerializable
{
    protected int $id;
    protected string $fullname;
    protected string $cellphone;
    protected string $license;
    protected string $ci;
    protected string $picture;
    protected int $status;
    protected int $ownerId;
    protected string $email;
    protected string $password;

    protected string $username;
   
    protected string $role;

    public function __construct($id, $fullname, $cellphone, $license, $ci, $picture, $ownerId, $status = 1)
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->cellphone = $cellphone;
        $this->license = $license;
        $this->ci = $ci;
        $this->picture = $picture;
        $this->ownerId = $ownerId;
        $this->status = $status;
    }
    public function __construct2($id, $fullname, $cellphone, $license, $ci, $picture, $ownerId, $status = 1,$username,$password,$role)
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->cellphone = $cellphone;
        $this->license = $license;
        $this->ci = $ci;
        $this->picture = $picture;
        $this->ownerId = $ownerId;
        $this->status = $status;
        
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

     public function __construct1($id, $fullname, $cellphone, $license, $ci)
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->cellphone = $cellphone;
        $this->license = $license;
        $this->ci = $ci;       
    }

    public function __construct($id, $fullname, $cellphone, $license, $ci, $picture, $ownerId, $email, $password, $status = 1)
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->cellphone = $cellphone;
        $this->license = $license;
        $this->ci = $ci;
        $this->picture = $picture;
        $this->ownerId = $ownerId;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
    }

    /**
     * @return array<string, mixed> driver attributes to array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'cellphone' => $this->cellphone,
            'license' => $this->license,
            'ci' => $this->ci,
            'picture' => $this->picture,
            'ownerId' => $this->ownerId,
            'status' => $this->status,
            'username' => $this->username,
            'password'=> $this->password,
            'role' => $this->role
        ];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setRole($role){
        $this->role = $role;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRole(){
        return $this->role;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function getCellphone() {
        return $this->cellphone;
    }

    public function getLicense() {
        return $this->license;
    }

    public function getCi() {
        return $this->ci;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getOwnerId() {
        return $this->ownerId;
    }

}
