
<?php
require_once '../Model/User.php';

if(isset($_POST['submit'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $data = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'address' => $address,
        'email' => $email,
        'phone' => $phone,
        'password' => $password
    ];

    // Validate
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

    if(empty($password)){ // Check if password is empty
        $errors["password"] = 'Password is required';
    }
    else{
        if(strlen($password) < 8){ // Check if password is at least 8 characters
            $errors["password"] = 'Password must be at least 8 characters';
        }
    }

    if(count($errors) > 0){ // If there are errors, redirect to reg.php with errors
        header('Location: ../View/reg.php?errors='.json_encode($errors).'&data='.json_encode($data));
        exit();
    }

    $reg = new User($firstName, $lastName, $address, $email, $phone, $password);
    if($reg->register()){
        header('Location: ../View/login.php?reg=success');
    }
    else{
        header('Location: ../View/reg.php?reg=failed');
    }
}
else{
    header('Location: ../View/reg.php');
}