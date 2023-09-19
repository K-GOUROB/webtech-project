<?php include_once "./Global/header.php" ?>
<?php include_once './Partial/navbar.php'; ?>
<div class="container d-flex justify-content-center mt-2">
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
  if (isset($_GET['errors'])) {
    $errors = json_decode($_GET['errors'], true);
  }

  if (isset($_GET['data'])) {
    $data = json_decode($_GET['data'], true);
  }
  if (isset($_SESSION['user'])) {
    echo '<script>window.location.href = "../View/sweetshop.php";</script>';
  }
  ?>
  <div class="card w-100">
    <div class="card-header bg-teal text-white">
      Account Creation
    </div>
    <div class="card-body">
      <form action="../Controller/RegController.php" method="post">
        <div class="form-group">
          <label for="firstName">First Name</label>
          <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Enter First Name" value="<?php if (isset($data['firstName'])) echo $data['firstName'] ?>">
          <?php if (isset($errors['firstName'])) : ?>
            <small class="text-danger"><?php echo $errors['firstName']; ?></small>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="lastName">Last Name</label>
          <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Enter Last Name" value="<?php if (isset($data['lastName'])) echo $data['lastName'] ?>">
          <?php if (isset($errors['lastName'])) : ?>
            <small class="text-danger"><?php echo $errors['lastName']; ?></small>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address" value="<?php if (isset($data['address'])) echo $data['address'] ?>">
          <?php if (isset($errors['address'])) : ?>
            <small class="text-danger"><?php echo $errors['address']; ?></small>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="<?php if (isset($data['email'])) echo $data['email'] ?>">
          <?php if (isset($errors['email'])) : ?>
            <small class="text-danger"><?php echo $errors['email']; ?></small>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter Phone Number" value="<?php if (isset($data['phone'])) echo $data['phone'] ?>">
          <?php if (isset($errors['phone'])) : ?>
            <small class="text-danger"><?php echo $errors['phone']; ?></small>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" value="<?php if (isset($data['password'])) echo $data['password'] ?>">
          <?php if (isset($errors['password'])) : ?>
            <small class="text-danger"><?php echo $errors['password']; ?></small>
          <?php endif; ?>
        </div>
        <button type="submit" name="submit" value="register" class="mt-2 btn btn-success w-100">Register Now</button>
      </form>
    </div>
  </div>
</div>

<?php include_once "./Global/footer.php" ?>