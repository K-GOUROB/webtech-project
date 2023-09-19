<?php include_once "./Global/header.php"?>
    <?php include_once './Partial/navbar.php'; ?>

    <?php 
        require_once "../Controller/SweetController.php";
        //addtocart.php?id=<?php echo $sweet['uid'] 

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sweet = SweetController::getSweetById($id);
            //if same sweet is added to cart, it will not be added again just the quantity will be increased
            if(isset($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $key => $value){
                    if($value['uid'] == $sweet['uid']){
                        $_SESSION['cart'][$key]['quantity']++;
                        header("Location: sweetshop.php?addedtocart=true");
                        return;
                    }
                }
            }
            $sweet['quantity'] = 1;
            $_SESSION['cart'][] = $sweet;
            header("Location: sweetshop.php?addedtocart=true");
        }

        if(isset($_SESSION['cart'])){
            $cart = $_SESSION['cart'];
        }
    ?>

    <div class="container mt-2 mb-2">
        <h1>
            Cart Items
        </h1>
        <div class="row">
            <div class="col-12">
                <?php if(isset($cart)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-black">
                            <?php foreach($cart as $item): ?>
                                <tr>
                                    <td><?php echo $item['name'] ?></td>
                                    <td><?php echo $item['price'] ?></td>
                                    <td><?php echo $item['quantity'] ?></td>
                                    <td><?php echo $item['price'] * $item['quantity'] ?></td>
                                    <td>
                                        <a href="removefromcart.php?id=<?php echo $item['uid'] ?>" class="btn btn-danger">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        No items in cart!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php include_once "./Global/footer.php"?>