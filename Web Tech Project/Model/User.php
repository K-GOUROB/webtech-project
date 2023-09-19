<?php 
require_once "../Model/FileIO.php";
class User{
    private $firstName;
    private $lastName;
    private $address;
    private $email;
    private $phone;
    private $password;
    private $fileIO;

    public function __construct($firstName, $lastName, $address, $email, $phone, $password){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->fileIO = new FileIO();
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getPassword(){
        return $this->password;
    }

    public function register(){
        $data = [
            'uid' => uniqid(),
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password
        ];
        if($this->fileIO->writeJson('../Model/File/users.json', $data)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function login($email,$password){
        $fileIO = new FileIO();
        $users = $fileIO->readJson('../Model/File/users.json');
        $data = [];
        foreach($users as $user){
            if($user['email'] == $email && $user['password'] == $password){
                $data = [
                    'uid' => $user['uid'],
                    'firstName' => $user['firstName'],
                    'lastName' => $user['lastName'],
                    'address' => $user['address'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'password' => $user['password']
                ];
                return $data;
            }
        }
        return false;
    } 

    public static function editProfile($uid, $firstName, $lastName, $email, $phone, $address){
        $fileIO = new FileIO();
        $users = $fileIO->readJson('../Model/File/users.json');
        $data = [];
        foreach($users as $user){
            if($user['uid'] == $uid){
                //edit that user dont add as new one 
                $data = [
                    'uid' => $uid,
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'address' => $address,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $user['password']
                ];
                if($fileIO->updateJson('../Model/File/users.json', $data)){
                    return $data;
                }
                else{
                    return false;
                }
            }
        }
        return false;
    }
}