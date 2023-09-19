<?php include_once "./Global/header.php"?>
    <?php include_once './Partial/navbar.php'; ?>

    <?php 
        require_once "../Controller/ProfileController.php";
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
        }
        else{
            header("Location: ./login.php");
        }

        if(isset($_POST['submit'])){
            $uid = $user['uid'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            $userEdited = ProfileController::EditProfile($uid, $firstName, $lastName, $email, $phone, $address);
            if(!$userEdited){
                header("Location: ./profile.php?edited=false");
            }
            else
            {
                $user['firstName'] = $firstName;
                $user['lastName'] = $lastName;
                $user['email'] = $email;
                $user['phone'] = $phone;
                $user['address'] = $address;

                $_SESSION['user'] = $user;
                header("Location: ./profile.php?edited=true");
            }
        }
    ?>

    <div class="container mt-2">
        <h1>
            Edit Profile
        </h1>
        <div>
            <div class="row">
                <div class="col-6">
                    <form action="" method="post">
                        <h3>Personal Information</h3>
                        <p>
                            <b>First Name: </b>
                            <input type="text" name="firstName" value="<?php echo $user['firstName'] ?>">
                        </p>
                        <p>
                            <b>Last Name: </b>
                            <input type="text" name="lastName" value="<?php echo $user['lastName'] ?>">
                        </p>
                        <p>
                            <b>Email: </b>
                            <input type="text" name="email" value="<?php echo $user['email'] ?>">
                        </p>
                        <p>
                            <b>Phone: </b>
                            <input type="text" name="phone" value="<?php echo $user['phone'] ?>">
                        </p>
                        <p>
                            <b>Address: </b>
                            <input type="text" name="address" value="<?php echo $user['address'] ?>">
                        </p>
                        <input type="submit" name="submit" value="Edit Now" class="btn btn-success">
                    </form>
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