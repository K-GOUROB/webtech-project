<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $pass = md5($_POST['pass']);
   $cpass = md5($_POST['cpass']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user email already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, phone, password, image) VALUES(?,?,?,?,?)");
         $insert->execute([$name, $email, $phone, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'registered successfully!';
               header('location:login.php');
            }
         }

      }
   }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">
</head>
<body>
<?php include 'regheader.php'; ?>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<section class="form-container">
   <form action="" enctype="multipart/form-data" method="POST">
      <h3>register now</h3>
      <input type="text" name="name" id="name" class="box" placeholder="enter your name" required>
      <div id="nameError" class="error"></div>
      
      <input type="email" name="email" id="email" class="box" placeholder="enter your email" required>
      <div id="emailError" class="error"></div>
      
      <input type="tel" name="phone" id="phone" class="box" placeholder="enter your phone" required>
      <div id="phoneError" class="error"></div>
      
      <input type="password" name="pass" id="pass" class="box" placeholder="enter your password" required>
      <div id="passwordError" class="error"></div>
      
      <input type="password" name="cpass" id="cpass" class="box" placeholder="confirm your password" required>
      <div id="cpassError" class="error"></div>
      
      <input type="file" name="image" id="image" class="box" required accept="image/jpg, image/jpeg, image/png">
      <div id="imageError" class="error"></div>
      
      <input type="submit" value="register now" class="btn" name="submit">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</section>

<script>
document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault();
    if (validateForm()) {
        this.submit();
    }
});
function validateForm() {
    // Get the form inputs
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const password = document.getElementById('pass');
    const confirmPassword = document.getElementById('cpass');
    const image = document.getElementById('image');

    // Get the error message elements
    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const phoneError = document.getElementById('phoneError');
    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('cpassError');
    const imageError = document.getElementById('imageError');
    // Set a flag to track if the form is valid or not
    let isValid = true;

    // Check the name field
    if (name.value.trim() === '') {
        nameError.textContent = 'Name is required';
        isValid = false;
    } else {
        nameError.textContent = '';
    }

    // Check the email field
    if (email.value.trim() === '') {
        emailError.textContent = 'Email is required';
        isValid = false;
    } else if (!isValidEmail(email.value.trim())) {
        emailError.textContent = 'Please enter a valid email address';
        isValid = false;
    } else {
        emailError.textContent = '';
    }

    // Check the phone field
    if (phone.value.trim() === '') {
        phoneError.textContent = 'Phone number is required';
        isValid = false;
    } else if (!isValidPhone(phone.value.trim())) {
        phoneError.textContent = 'Please enter a valid phone number';
        isValid = false;
    } else {
        phoneError.textContent = '';
    }

    // Check the password field
    if (password.value.trim() === '') {
        passwordError.textContent = 'Password is required';
        isValid = false;
    } else if (password.value.trim().length < 6) {
        passwordError.textContent = 'Password must be at least 6 characters long';
        isValid = false;
    } else {
        passwordError.textContent = '';
    }

    // Check the confirm password field
    if (confirmPassword.value.trim() === '') {
        confirmPasswordError.textContent = 'Confirm password is required';
        isValid = false;
    } else if (password.value.trim() !== confirmPassword.value.trim()) {
        confirmPasswordError.textContent = 'Passwords do not match';
        isValid = false;
    } else {
        confirmPasswordError.textContent = '';
    }
    
    // Check the image field
    if (image.value === '') {
        imageError.textContent = 'Image is required';
        isValid = false;
    } else if (!isValidImage(image.value)) {
        imageError.textContent = 'Please select a valid image file (JPG, JPEG, PNG)';
        isValid = false;
    } else if (image.files[0].size > 2000000) {
        imageError.textContent = 'Image file size is too large (max 2MB)';
        isValid = false;
    } else {
        imageError.textContent = '';
    }

    // Return the form validation status
    return isValid;
}

function isValidEmail(email) {
    // A simple email validation regular expression
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    // A simple phone number validation regular expression
    const phoneRegex = /^\d{10}$/;
    return phoneRegex.test(phone);
}

function isValidImage(image) {
    // A simple image file validation regular expression
    const imageRegex = /\.(jpg|jpeg|png)$/i;
    return imageRegex.test(image);
}

</script>
<?php @include_once 'footer.php'; ?>
</body>
</html>
