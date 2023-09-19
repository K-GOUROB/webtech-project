<?php 
require_once '../Model/User.php';
if(isset($_POST['submit'])){
    $data = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate
    $errors = [];
    if(empty($email)){ // Check if email is empty
        $errors["email"] = 'Email is required';
    }
    else{ // Check if email is valid
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors["email"] = 'Email is invalid';
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

    if(count($errors) > 0){
        header('Location: ../View/login.php?errors=' . json_encode($errors).'&data='.json_encode($data));
        exit();
    }

    $user = User::login($email, $password);
    if($user){
        session_start();
        $_SESSION['user'] = $user;
        header('Location: ../View/sweetshop.php');
    }
    else{
        header('Location: ../View/login.php?login=failed');
    }
}
else{
    header('Location: ../View/login.php');
}