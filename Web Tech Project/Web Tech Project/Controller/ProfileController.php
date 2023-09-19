<?php
require_once "../Model/User.php";
class ProfileController{
    public static function EditProfile($uid,$firstName, $lastName, $email, $phone, $address){
        $user = [
            'uid' => $uid,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];

        //Validate

        $errors = [];
        if(empty($firstName)){ // Check if first name is empty
            $errors["firstName"] = 'First Name is required';
        }

        if(empty($lastName)){ // Check if last name is empty
            $errors["lastName"] = 'Last Name is required';
        }

        if(empty($address)){ // Check if address is empty
            $errors["address"] = 'Address is required';
        }

        if(empty($email)){ // Check if email is empty
            $errors["email"] = 'Email is required';
        }
        else{ // Check if email is valid
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors["email"] = 'Email is invalid';
            }
        }

        if(empty($phone)){ // Check if phone is empty
            $errors["phone"] = 'Phone is required';
        }
        else{
            if(!preg_match('/^[0-9]{10}+$/', $phone)){ // Check if phone is valid
                $errors["phone"] = 'Phone is invalid';
            }
        }

        $editUser = User::editProfile($uid, $firstName, $lastName, $email, $phone, $address);
        if($editUser){
            return $editUser;
        }
        else{
            return false;
        }
    }
}