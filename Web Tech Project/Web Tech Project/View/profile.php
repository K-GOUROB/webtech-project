<?php include_once "./Global/header.php"?>
    <?php include_once './Partial/navbar.php'; ?>

    <?php 
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
        }
        else{
            header("Location: ./login.php");
        }
    ?>

    <div class="container">
        <?php 
            if(isset($_GET['edited'])){
                if($_GET['edited'] == 'true'){
                    echo "<div class='alert alert-success' role='alert'>
                    Profile edited successfully!
                  </div>";
                }
                else{
                    echo "<div class='alert alert-danger' role='alert'>
                    Profile edited failed!
                  </div>";
                }
            }
        ?>
        <h1>Hey, 
            <?php echo $user['firstName'] ?>
        </h1>
        <div>
            <a href="./editProfile.php" class="btn btn-info">Edit Profile</a>
            <div class="row">
                <div class="col-6">
                    <h3>Personal Information</h3>
                    <p>
                        <b>First Name: </b>
                        <?php echo $user['firstName'] ?>
                    </p>
                    <p>
                        <b>Last Name: </b>
                        <?php echo $user['lastName'] ?>
                    </p>
                    <p>
                        <b>Email: </b>
                        <?php echo $user['email'] ?>
                    </p>
                    <p>
                        <b>Phone: </b>
                        <?php echo $user['phone'] ?>
                    </p>
                    <p>
                        <b>Address: </b>
                        <?php echo $user['address'] ?>
                    </p>
                </div>
                <div class="col-6">
                    <h3>Payment Information</h3>
                    <p>
                        <b>Card Number: </b>
                        Later on, we will encrypt this data
                    </p>
                    <p>
                        <b>Card Holder: </b>
                        Later on, we will encrypt this data
                    </p>
                    <p>
                        <b>Expiry Date: </b>
                        Later on, we will encrypt this data
                    </p>
                    <p>
                        <b>CVV: </b>
                        Later on, we will encrypt this data
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php include_once "./Global/footer.php"?>