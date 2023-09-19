<?php include_once "./Global/header.php"?>
    <?php include_once './Partial/navbar.php'; ?>
    <?php 
        require_once "../Controller/SweetController.php";
        $sweets = SweetController::getAllSweets();
        //var_dump($sweets)

        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
        }
        else{
            header("Location: ./login.php");
        }

        if(isset($_GET['addedtocart'])){
            echo "<div class='alert alert-success' role='alert'>
            Added to cart successfully!
          </div>";
        }

        if(isset($_SESSION['cart'])){
            $cart = $_SESSION['cart'];
            $total = 0;
            foreach($cart as $item){
                $total += $item['price'] * $item['quantity'];
            }
            echo "<div class='container alert alert-info' role='alert'>
            Total Price: $total
          </div>";
        }

        if(isset($_POST['area'])){
            $area = $_POST['area'];
            $sweets = SweetController::getSweetsByArea($area);
        }
    ?>
<style>
    .card-img-top{
        object-fit: cover;
    }

    .card{
        border: none;
        border-radius: 0;
    }

    .card-body{
        background-color: #2E2E2E;
    }

    .card-title{
        font-size: 1.5rem;
    }

    .card-text{
        font-size: 1.2rem;
    }

    .card:hover{
        box-shadow: 0 0 10px 0 rgba(0,0,0,0.2);
    }

    .card:hover .card-body{
        background-color: #f8f9fa;
    }

    .card:hover .card-title{
        color: #000;
    }

    .card:hover .card-text{
        color: #000;
    }

    .card:hover .card-img-top{
        opacity: 0.5;
    }

    .card:hover .card-img-top:hover{
        opacity: 1;
    }
</style>
<div class="container mt-5 mb-5">
    <form action="" method="post">
        <div class="input-group mb-3">
                <select class="form-select" id="inputGroupSelect02" name="area">
                <option value="All" 
                <?php 
                    if(isset($_POST['area'])){
                        if($_POST['area'] == "All"){
                            echo "selected";
                        }
                    }
                ?>
                >All</option>
                <option value="Dhaka"
                <?php 
                    if(isset($_POST['area'])){
                        if($_POST['area'] == "Dhaka"){
                            echo "selected";
                        }
                    }
                ?>
                >Dhaka</option>
                <option value="Chittagong"
                <?php 
                    if(isset($_POST['area'])){
                        if($_POST['area'] == "Chittagong"){
                            echo "selected";
                        }
                    }
                ?>
                >Chittagong</option>
                <option value="Tangail"
                <?php 
                    if(isset($_POST['area'])){
                        if($_POST['area'] == "Tangail"){
                            echo "selected";
                        }
                    }
                ?>
                >Tangail</option>
                <option value="Rajshahi"
                <?php 
                    if(isset($_POST['area'])){
                        if($_POST['area'] == "Rajshahi"){
                            echo "selected";
                        }
                    }
                ?>
                >Rajshahi</option>
                <option value="Barishal"
                <?php 
                    if(isset($_POST['area'])){
                        if($_POST['area'] == "Barishal"){
                            echo "selected";
                        }
                    }
                ?>
                >Barishal</option>
                <option value="Sylhet"
                <?php 
                    if(isset($_POST['area'])){
                        if($_POST['area'] == "Sylhet"){
                            echo "selected";
                        }
                    }
                ?>
                >Sylhet</option>
                <option value="Rangpur"
                <?php 
                    if(isset($_POST['area'])){
                        if($_POST['area'] == "Rangpur"){
                            echo "selected";
                        }
                    }
                ?>
                >Rangpur</option>
            </select>
            <button class="btn btn-primary" type="submit" id="button-addon2">Apply</button>
        </div>
    </form>
  <div class="row row-cols-1 row-cols-md-3 g-4 text-black">
    <?php if(count($sweets) == 0): ?>
        <div class="alert alert-danger" role="alert">
            No sweets found!
        </div>
    <?php endif; ?>
    <?php foreach($sweets as $sweet): ?>
    <div class="col">
      <div class="card h-100">
        <img src="<?php
        echo $sweet['image']
        ?>" height="120px" width="40px" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">
                Name: <?php echo $sweet['name'] ?>
            </h5>
            <p class="card-text">
                Price: <?php echo $sweet['price'] ?>
            </p>
            <p class="card-text">
                Quantity: <?php echo $sweet['quantity'] ?>
            </p>
            <p class="card-text">
                Description: <?php echo $sweet['description'] ?>
            </p>
            <a href="./addtocart.php?id=<?php echo $sweet['uid'] ?>" class="btn btn-primary">Add to Cart</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    </div>
  </div>
</div>
<?php include_once "./Global/footer.php"?>