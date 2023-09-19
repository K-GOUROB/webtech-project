<?php include_once "./Global/header.php" ?>
<?php include_once './Partial/navbar.php'; ?>
<style>
   body {
      background-color: #006666;
   }

   .wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
   }

   .login-box {
      position: relative;
      max-width: 400px;
      width: 90%;
      margin: 0 auto;
      background-color: #FFFFFF;
      border-radius: 5px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
      overflow: hidden;
   }

   .login-header {
      position: relative;
      background-color: #FF4136;
      text-align: center;
      padding: 30px 0;
   }

   .login-header h2 {
      color: #FFFFFF;
      font-size: 24px;
      margin: 0;
   }

   .login-header i {
      font-size: 48px;
      margin-bottom: 20px;
      display: block;
   }

   .login-body {
      padding: 30px;
   }

   .form-group {
      margin-bottom: 20px;
   }

   .form-group label {
      display: block;
      margin-bottom: 5px;
      font-size: 16px;
      font-weight: bold;
   }

   .form-control {
      width: 100%;
      height: 40px;
      font-size: 16px;
      padding: 10px;
      border-radius: 5px;
      border: none;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
   }

   .btn-primary {
      background-color: #FF4136;
      border-color: #FF4136;
   }

   .btn-primary:hover {
      background-color: #FF6347;
      border-color: #FF6347;
   }

   .btn-block {
      display: block;
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      font-size: 16px;
      color: #FFFFFF;
      background-color: #FF4136;
      border-color: #FF4136;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
      transition: all 0.3s ease-in-out;
   }

   .btn-block:hover {
      background-color: #FF6347;
      border-color: #FF6347;
      cursor: pointer;
   }

   /* Animation */
   .login-box:before {
      content: "";
      position: absolute;
      top: -10px;
      left: -10px;
      right: -10px;
      bottom: -10px;
      background-color: #FFFFFF;
      z-index: -1;
      border-radius: 50%;
      animation: animate 25s linear infinite;
   }

   @keyframes animate {
      0% {
         transform: scale(1);
         opacity: 1;
      }

      100% {
         transform: scale(10);
         opacity: 0;
      }
   }

   .login-header i {
      animation: icon-animation 2s ease-in-out infinite;
   }

   @keyframes icon-animation {
      0% {
         transform: translateY(0);
      }

      50% {
         transform: translateY(-20px);
      }

      100% {
         transform: translateY(0);
      }
   }

   .login-body {
      animation: form-animation 1s ease-in-out;
      animation-delay: 0.5s;
   }

   @keyframes form-animation {
      0% {
         transform: translateY(-50px);
         opacity: 0;
      }

      100% {
         transform: translateY(0);
         opacity: 1;
      }
   }
</style>

<?php
if (isset($_GET['reg'])) {
   if ($_GET['reg'] == 'success') {
      echo '<div class="alert alert-success" role="alert">
                  Account created successfully!
              </div>';
   } else if ($_GET['reg'] == 'failed') {
      echo '<div class="alert alert-danger" role="alert">
                  Account creation failed!
              </div>';
   }
}

if (isset($_GET['login'])) {
   if ($_GET['login'] == 'failed') {
      echo '<div class="alert alert-danger" role="alert">
                  Login failed!
              </div>';
   }
}

if (isset($_GET['logout'])) {
   if ($_GET['logout'] == 'success') {
      echo '<div class="alert alert-success" role="alert">
                  Logout success!
              </div>';
   }
}

if (isset($_GET['data'])) {
   $data = json_decode($_GET['data']);
}

if (isset($_SESSION['user'])) {
   echo '<script>window.location.href = "../View/sweetshop.php";</script>';
}
?>
<div class="wrapper">
   <div class="login-box">
      <div class="login-header">
         <h2><i class="fas fa-user"></i> Login</h2>
      </div>
      <div class="login-body">
         <?php
         if (isset($_GET['errors'])) {
            $errors = json_decode($_GET['errors']);
            foreach ($errors as $error) {
               echo '<div class="container alert alert-danger" role="alert">
                           ' . $error . '
                       </div>';
            }
         }
         ?>
         <form novalidate action="../Controller/LoginController.php" method="post">
            <div class="form-group">
               <label for="username"><i class="fas fa-envelope"></i> Email</label>
               <input type="text" name="email" class="form-control" id="username" placeholder="Enter Email" required
                  value="<?php if (isset($data)) {
                              echo $data->email;
                           } ?>"
               >
            </div>
            <div class="form-group">
               <label for="password"><i class="fas fa-lock"></i> Password</label>
               <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required
                  value="<?php if (isset($data)) {
                              echo $data->password;
                           } ?>"
               >
            </div>
            <button type="submit" name="submit" value="login" class="btn btn-primary btn-block">Login</button>
         </form>
      </div>
   </div>
</div>

<?php include_once "./Global/footer.php" ?>