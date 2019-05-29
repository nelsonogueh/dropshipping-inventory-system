<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once('include/_initialize.php');

$db = new DB_Helper();


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - 1688 items</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Data-Table-1.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
</head>

<body>
<nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-white portfolio-navbar gradient">
    <div class="container"><a class="navbar-brand logo" href="./">Dropshipping items</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav"><span class="sr-only">Toggle navigation</span><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse"
             id="navbarNav">
            <ul class="nav navbar-nav ml-auto">
                <li>
                    <form action="./" method="get" class="form-inline">
                        <input type="search" name="search"
                               class="form-control"
                               placeholder="Search..."/>
                        <input
                            type="submit" class="btn btn-warning btn-outline-dark" value="search"/>
                    </form>
                </li>
                <li class="nav-item" role="presentation"><a class="nav-link active" href="./">Home</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="row" style="margin-bottom: 20px;">
    <section class="col-md-12" style="margin-top: 80px;">
        <div class="col-sm-4">

            <?php
            if (!isset($_GET['edit-submitted-id'])) { // If edit id is not passed (INSERT)
                if (isset($_FILES['image']) && isset($_POST['item-name'])) { // If image is set
                    $fileName = "";
                    $sku = "";
                    $itemURL1688 = "";
                    $price1688 = "";
                    $weightKG = "";
                    $imageName = "";

                    $fileName = mysqli_real_escape_string($db->conn, $_POST['item-name']);
                    $sku = "ESH" . str_ireplace(".", "", microtime()); // Generating our SKU

                    $itemURL1688 = mysqli_real_escape_string($db->conn, $_POST['item-url-1688']);
                    $price1688 = mysqli_real_escape_string($db->conn, $_POST['price-1688']);
                    $weightKG = mysqli_real_escape_string($db->conn, $_POST['weight-kg']);

                    $errors = array();
                    $imageName = $_FILES['image']['name'];
                    $file_size = $_FILES['image']['size'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];


                    $explodeVariable = explode('.', $imageName);
                    $toMakeLowerCase = end($explodeVariable);
                    $file_ext = strtolower($toMakeLowerCase);

                    $extensions = array("jpeg", "jpg", "png", "gif", "svg");

                    $finalFileName = mysqli_real_escape_string($db->conn, $fileName) . "_" .str_ireplace(".", "", microtime()) . "." . $file_ext;
                    $finalFilePath = "item_images/" . $finalFileName;

                    if (in_array($file_ext, $extensions) === false) {
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file. \n";
                    }

                    if ($file_size > 5084597152) {
                        $errors[] = 'File too large. \n';
                    }

                    if (empty($errors) == true) {
                        if (move_uploaded_file($file_tmp, $finalFilePath)) {
                            $insert = mysqli_query($db->conn, "INSERT INTO items (item_name,item_url_1688,our_sku, item_image,item_price_yuan,item_weight_kg,date_added) VALUES ('$fileName','$itemURL1688','$sku','$finalFilePath','$price1688','$weightKG','$db->date')");
                            if ($insert) {
                                $_SESSION['response_code'] = "1";
                                $_SESSION['response_message'] = "Item added successfully!";
                            } else {
                                $_SESSION['response_code'] = "0";
                                $_SESSION['response_message'] = "Item could not be added!";
                            }
                        } else {
                            $finalFilePath = ""; // No image name
                            $insert = mysqli_query($db->conn, "INSERT INTO items (item_name,item_url_1688,our_sku, item_image,item_price_yuan,item_weight_kg,date_added) VALUES ('$fileName','$itemURL1688','$sku','$finalFilePath','$price1688','$weightKG','$db->date')");
                            if ($insert) {
                                $_SESSION['response_code'] = "1";
                                $_SESSION['response_message'] = "Item added successfully!";
                            } else {
                                $_SESSION['response_code'] = "0";
                                $_SESSION['response_message'] = "Item could not be added!";
                            }

                        }

                    } else {
                        $finalFilePath = ""; // No image name
                        $insert = mysqli_query($db->conn, "INSERT INTO items (item_name,item_url_1688,our_sku, item_image,item_price_yuan,item_weight_kg,date_added) VALUES ('$fileName','$itemURL1688','$sku','$finalFilePath','$price1688','$weightKG','$db->date')");
                        if ($insert) {
                            $_SESSION['response_code'] = "1";
                            $_SESSION['response_message'] = "Item added successfully!";
                        } else {
                            $_SESSION['response_code'] = "0";
                            $_SESSION['response_message'] = "Item could not be added!";
                        }

                    }


                    echo "<br />";
                } elseif (isset($_POST['item-name'])) { // If image is not set

                    $fileName = "";
                    $sku = "";
                    $itemURL1688 = "";
                    $price1688 = "";
                    $weightKG = "";

                    $fileName = mysqli_real_escape_string($db->conn, $_POST['item-name']);
                    $sku = "ESH" . str_ireplace(".", "", microtime());
                    $itemURL1688 = mysqli_real_escape_string($db->conn, $_POST['item-url-1688']);
                    $price1688 = mysqli_real_escape_string($db->conn, $_POST['price-1688']);
                    $weightKG = mysqli_real_escape_string($db->conn, $_POST['weight-kg']);

                    $finalFilePath = ""; // No image name
                    $update = mysqli_query($db->conn, "UPDATE items SET
item_name = '$fileName',
item_url_1688 = '$itemURL1688',
our_sku = '$sku',
item_image = '$finalFilePath',
item_price_yuan = '$price1688',
item_weight_kg = '$weightKG',
date_added = '$db->date'

WHERE id = '$item_id'
");
                    if ($update) {
                        $_SESSION['response_code'] = "1";
                        $_SESSION['response_message'] = "Item updated successfully!";
                    } else {
                        $_SESSION['response_code'] = "0";
                        $_SESSION['response_message'] = "Item could not be updated!";
                    }
                }
            } elseif (isset($_GET['edit-submitted-id']) && !empty(trim($_GET['edit-submitted-id']))) { // If edit id is passed (UPDATE)

                $item_id = mysqli_real_escape_string($db->conn, $_GET['edit-submitted-id']);
                if (isset($_FILES['image']) && isset($_POST['item-name'])) { // If image is set
                    $fileName = "";
                    $itemURL1688 = "";
                    $price1688 = "";
                    $weightKG = "";
                    $imageName = "";

                    $fileName = mysqli_real_escape_string($db->conn, $_POST['item-name']);

                    $itemURL1688 = mysqli_real_escape_string($db->conn, $_POST['item-url-1688']);
                    $price1688 = mysqli_real_escape_string($db->conn, $_POST['price-1688']);
                    $weightKG = mysqli_real_escape_string($db->conn, $_POST['weight-kg']);

                    $errors = array();
                    $imageName = $_FILES['image']['name'];
                    $file_size = $_FILES['image']['size'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];


                    $explodeVariable = explode('.', $imageName);
                    $toMakeLowerCase = end($explodeVariable);
                    $file_ext = strtolower($toMakeLowerCase);

                    $extensions = array("jpeg", "jpg", "png", "gif", "svg");

                    $finalFileName = mysqli_real_escape_string($db->conn, $fileName) . "_" .str_ireplace(".", "", microtime()) . "." . $file_ext;
                    $finalFilePath = "item_images/" . $finalFileName;

                    if (in_array($file_ext, $extensions) === false) {
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file. \n";
                    }

                    if ($file_size > 5084597152) {
                        $errors[] = 'File too large. \n';
                    }

                    if (empty($errors) == true) {
                        $imageOfItem = "";
                        if (move_uploaded_file($file_tmp, $finalFilePath)) {

                            $fetchImage = mysqli_query($db->conn, "SELECT item_image FROM items WHERE id = '$item_id'");
                            if (mysqli_num_rows($fetchImage) > 0) {
                                $row = mysqli_fetch_array($fetchImage);
                                $imageOfItem = $row['item_image'];

                            }
                            unlink($imageOfItem);

                            $update = mysqli_query($db->conn, "UPDATE items SET
item_name = '$fileName',
item_url_1688 = '$itemURL1688',
item_image = '$finalFilePath',
item_price_yuan = '$price1688',
item_weight_kg = '$weightKG',
date_added = '$db->date'

WHERE id = '$item_id'
");
                            if ($update) {
                                $_SESSION['response_code'] = "1";
                                $_SESSION['response_message'] = "Item updated successfully!";
                            } else {
                                $_SESSION['response_code'] = "0";
                                $_SESSION['response_message'] = "Item could not be updated!";
                            }
                        } else {
                            $finalFilePath = ""; // No image name
                            $update = mysqli_query($db->conn, "UPDATE items SET
item_name = '$fileName',
item_url_1688 = '$itemURL1688',
item_image = '$finalFilePath',
item_price_yuan = '$price1688',
item_weight_kg = '$weightKG',
date_added = '$db->date'

WHERE id = '$item_id'

");
                            if ($update) {
                                $_SESSION['response_code'] = "1";
                                $_SESSION['response_message'] = "Item updated successfully!";
                            } else {
                                $_SESSION['response_code'] = "0";
                                $_SESSION['response_message'] = "Item could not be updated!";
                            }

                        }

                    } else {
                        $finalFilePath = ""; // No image name
                        $update = mysqli_query($db->conn, "UPDATE items SET
item_name = '$fileName',
item_url_1688 = '$itemURL1688',
item_image = '$finalFilePath',
item_price_yuan = '$price1688',
item_weight_kg = '$weightKG',
date_added = '$db->date'

WHERE id = '$item_id'
");
                        if ($update) {
                            $_SESSION['response_code'] = "1";
                            $_SESSION['response_message'] = "Item updated successfully!";
                        } else {
                            $_SESSION['response_code'] = "0";
                            $_SESSION['response_message'] = "Item could not be updated!";
                        }

                    }


                    echo "<br />";
                } elseif (isset($_POST['item-name'])) { // If image is not set

                    $fileName = "";
                    $itemURL1688 = "";
                    $price1688 = "";
                    $weightKG = "";
                    $imageName = "";

                    $fileName = mysqli_real_escape_string($db->conn, $_POST['item-name']);

                    $itemURL1688 = mysqli_real_escape_string($db->conn, $_POST['item-url-1688']);
                    $price1688 = mysqli_real_escape_string($db->conn, $_POST['price-1688']);
                    $weightKG = mysqli_real_escape_string($db->conn, $_POST['weight-kg']);


                    $finalFilePath = ""; // No image name
                    $update = mysqli_query($db->conn, "UPDATE items SET
item_name = '$fileName',
item_url_1688 = '$itemURL1688',
item_image = '$finalFilePath',
item_price_yuan = '$price1688',
item_weight_kg = '$weightKG',
date_added = '$db->date'

WHERE id = '$item_id'
");
                    if ($update) {
                        $_SESSION['response_code'] = "1";
                        $_SESSION['response_message'] = "Item updated successfully!";
                    } else {
                        $_SESSION['response_code'] = "0";
                        $_SESSION['response_message'] = "Item could not be updated!";
                    }

                }


            }
            echo "<br />";
            include_once('include/include_response_div.php');
            ?>


            <div class="heading">
                <h2>Add items</h2>
            </div>

            <form action="<?php if (isset($_GET['edit-id']) && !empty(trim($_GET['edit-id']))) {
                echo "./?edit-submitted-id=" . $_GET['edit-id'];
            } else {
                echo "./";
            } ?>" method="POST" enctype="multipart/form-data">
                <?php
                $fileName = "";
                $itemURL1688 = "";
                $price1688 = "";
                $weightKG = "";

                if (isset($_GET['edit-id']) && !empty(trim($_GET['edit-id']))) {
                    $item_id_now = mysqli_real_escape_string($db->conn, $_GET['edit-id']);

                    $fetchItems = mysqli_query($db->conn, "SELECT * FROM items WHERE id = '$item_id_now'");
                    if (mysqli_num_rows($fetchItems) > 0) {
                        $row = mysqli_fetch_array($fetchItems);
                        $editRequest = true;

                        $fileName = $row['item_name'];
                        $itemURL1688 = $row['item_url_1688'];
                        $price1688 = $row['item_price_yuan'];
                        $weightKG = $row['item_weight_kg'];
                        $imageName = $row['item_image'];

                    } else {
                        $editRequest = false;
                    }
                } else {
                    $editRequest = false;
                }
                ?>
                <div class="form-group">
                    <label for="name">Item name:</label>
                    <input class="form-control item" type="text" value="<?php if($editRequest){echo $fileName;} ?>" name="item-name"/>
                </div>
                <div class="form-group">
                    <label for="email">Vendor's item URL:</label>
                    <input class="form-control item" value="<?php if($editRequest){echo $itemURL1688;} ?>" type="text" name="item-url-1688"/>
                </div>
                <div class="form-group">
                    <label for="email">Item price (Yuan)</label>
                    <input class="form-control item" value="<?php if($editRequest){echo $price1688;} ?>" type="text" name="price-1688"/>
                </div>
                <div class="form-group">
                    <label for="email">Item weight (KG)</label>
                    <input class="form-control item" value="<?php if($editRequest){echo $weightKG;} ?>" type="text" name="weight-kg"/>
                </div>
                <div class="form-group">
                    <label for="email">Item image</label>
                    <input class="form-control item" value="<?php if($editRequest){echo $imageName;} ?>" type="file" name="image"/>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block btn-lg" type="submit"> <?php if($editRequest){echo "UPDATE";}else{echo "ADD";} ?></button>
                </div>
            </form>
        </div>
        <div class="col-sm-12" style="margin-top: 40px;">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Item image</th>
                    <th>Item name</th>
                    <th>Our SKU</th>
                    <th>Item price (Yuan)</th>
                    <th>Item weight (KG)</th>
                    <th>Vendor's item</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php

                if ((isset($_REQUEST['search'])) && (!empty(trim($_REQUEST['search'])))) {
                    $search_keyword = mysqli_real_escape_string($db->conn, $_REQUEST['search']);
                } else {
                    $search_keyword = "";
                }

                $start_at = 0;
                $length_to_pick = 5000000000000000000000000000000000;

                try {
                    $fetch_items = $db->fetchItemsWithSearch($start_at, $search_keyword, $length_to_pick);
                    foreach ($fetch_items as $item):
                        $item_id = $item['id'];
                        $item_name = $item['item_name'];
                        $item_url_1688 = $item['item_url_1688'];
                        $our_sku = $item['our_sku'];
                        $item_image = $item['item_image'];
                        $item_price_yuan = $item['item_price_yuan'];
                        $item_weight_kg = $item['item_weight_kg'];
                        $date_added = $item['date_added'];
                        ?>

                        <tr>
                            <td>
                                <center><a target="_blank" href="<?php echo $item_image; ?>"><img
                                            style="max-height: 80px;" src="<?php echo $item_image; ?>"/></a></center>
                            </td>
                            <td><?php echo $item_name; ?></td>
                            <td><?php echo $our_sku; ?></td>
                            <td><?php echo $item_price_yuan; ?></td>
                            <td><?php echo $item_weight_kg; ?></td>
                            <td><a target="_blank" href="<?php echo $item_url_1688; ?>">
                                    <button class="btn btn-primary">Click here</button>
                                </a></td>
                            <td>
                                <button onclick="window.location='index.php?edit-id='+<?php echo $item_id; ?>"
                                        class="btn btn-success">Edit
                                </button>
                                <button onclick="return(comfirm('Are you sure to delete?'))" class="btn btn-danger">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <?php
                    endforeach;

                } catch (Exception $e) {

                }
                ?>


                </tbody>
            </table>
        </div>
    </section>
</main>
<footer class="page-footer">
    <div class="container">
        <div class="links"><a href="#">About me</a><a href="#">Contact me</a><a href="#">Projects</a></div>
        <div class="social-icons"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i
                    class="icon ion-social-instagram-outline"></i></a><a href="#"><i
                    class="icon ion-social-twitter"></i></a></div>
    </div>
</footer>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
<script src="assets/js/theme.js"></script>
</body>

</html>