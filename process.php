<?php
require("database.php");
ob_start();

function retrieve(){
    global $conn;
    $result = $conn->query("SELECT *, (price * inventory) as available_inventory FROM products;");
        $data = array();
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        foreach($data as $row){
?>          <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['product_name'] ?></td>
                <td><?= $row['unit'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['expiry_date'] ?></td>
                <td><?= $row['inventory'] ?></td>
                <td><?= $row['available_inventory'] ?></td>
                <td><img src=<?= $row['image'] ?> alt="image" /></td>
                <td><a href="/#update-product" class="btn btn-success">Update</a><button class="btn btn-danger delete">Delete</button></td>
            </tr>
<?php


        }
}



    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        if($_POST['use'] == 'insert'){
            $productName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $unit = filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_SPECIAL_CHARS);
            $price = $_POST['price'];
            $inventory = $_POST['inventory'];
            $date = filter_input(INPUT_POST, 'xDate', FILTER_SANITIZE_SPECIAL_CHARS);
            $repos = 'images/';
            $image = $repos . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "error";
            }else{
                move_uploaded_file($_FILES["image"]["tmp_name"], $image);
                $conn->query("INSERT INTO products(product_name, unit, price, expiry_date, inventory, image, created_at, updated_at)
                                VALUES('{$productName}', '{$unit}', {$price}, '{$date}', {$inventory}, '{$image}', now(), now())");
                retrieve();
                $content = ob_get_clean();
                echo $content;
            }
        }
        else if($_POST['use'] == 'delete'){
            $conn->query("DELETE FROM products WHERE id = {$_POST['input']}");
            retrieve();
            $content = ob_get_clean();
            echo $content;
        }
        else if($_POST['use'] == 'update'){
            $result = $conn->query("SELECT * FROM products WHERE id={$_POST['id']}");
            if(empty(mysqli_fetch_assoc($result))){
                retrieve();
                $content = ob_get_clean();
                echo $content;
            }else{
                $productName = filter_input(INPUT_POST, 'u-name', FILTER_SANITIZE_SPECIAL_CHARS);
                $unit = filter_input(INPUT_POST, 'u-unit', FILTER_SANITIZE_SPECIAL_CHARS);
                $price = $_POST['u-price'];
                $inventory = $_POST['u-inventory'];
                $date = filter_input(INPUT_POST, 'u-xDate', FILTER_SANITIZE_SPECIAL_CHARS);
            
                $conn->query("UPDATE products SET product_name = '{$productName}', unit = '{$unit}', price = {$price}, expiry_date = '{$date}', inventory = {$inventory}, updated_at = NOW() WHERE id = {$_POST['id']}");
                
                if (!empty($_FILES["u-image"]["name"])) {
                    $repos = 'images/';
                    $image = $repos . basename($_FILES["u-image"]["name"]);
                    $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        echo "error";
                    }
                    else{
                        move_uploaded_file($_FILES["u-image"]["tmp_name"], $image);
                        $conn->query("UPDATE products SET image='{$image}'");
                    }
                }
                retrieve();
                $content = ob_get_clean();
                echo $content;
            }
            
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == "GET"){
        retrieve();
        $content = ob_get_clean();
        echo $content;
    }

?>