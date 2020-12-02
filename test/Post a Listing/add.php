<?php 

    session_start();
    include('../config.php');

    $title = $description = $price = $user = $image = $category = '';
    $errors = array('description' =>'', 'title' => '', 'price'=> '', 'user' => '', 'category' => '', 'image' => '');

    if(isset($_POST['submit'])){

        //check user
        if(empty($_POST['user'])){
            $errors['user'] = 'a user is required <br />';
        } else{
            $user = $_POST['user'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $user)){
                $errors['user'] = 'user must be letters and spaces only <br />';
            }
        }

        //check price
        if(empty($_POST['price'])){
            $errors['price'] = 'a price is required <br />';
        } else{
            $price = $_POST['price'];
            if(!preg_match('/^[0-9]\d*(\.\d+)?$/', $price)){
                $errors['price'] = 'price must be a number or decimal <br />';
            }
        }

        //image stuff
        $output_dir = "upload/";/* Path for file upload */
        $RandomNum   = time();
        $ImageName      = str_replace(' ','-',strtolower($_FILES['image']['name'][0]));
        $ImageType      = $_FILES['image']['type'][0];
 
        $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt       = str_replace('.','',$ImageExt);
        $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
        $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
        $ret[$NewImageName]= $output_dir.$NewImageName;
        /* Try to create the directory if it does not exist */
        if (!file_exists($output_dir))
        {
            @mkdir($output_dir, 0777);
        }               
        move_uploaded_file($_FILES["image"]["tmp_name"][0],$output_dir."/".$NewImageName );
    
        if(array_filter($errors)){
            //echo 'errors in the form';
        }else{
            $title = mysqli_real_escape_string($link, $_POST['title']);
            $description = mysqli_real_escape_string($link, $_POST['description']);
            $user = mysqli_real_escape_string($link, $_POST['user']);
            $price = mysqli_real_escape_string($link, $_POST['price']);


            //create sql
            $sql = "INSERT INTO additem(title,description,user,price,image) VALUES('$title', '$description', '$user', '$price', '$NewImageName')";

            //save to db and check
            if(mysqli_query($link, $sql)){
                //success
                header('Location: ../index.php');
            }else{
                echo 'query error: ' . mysqli_error($link);
            }
        }

    }
 ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Online Garage Sale</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <header>
            <h1 id="logo"><a href="../index.php">OGS</a></h1>
            <h2 id="addlisting"><a href="add.php">Post a Listing</a></h2>
        </header>

        <form class = "white" action = "add.php" method = "POST">
            <label>Your Name:</label>
            <input type = "text" name = "user" value = "<?php echo htmlspecialchars($user) ?>">
            <div class = "red-text"><?php echo $errors['user']; ?></div>
            <br>
            <label>Product Title:</label>
            <input type = "text" name = "title" value = "<?php echo htmlspecialchars($title) ?>">
            <div class = "red-text"><?php echo $errors['title']; ?></div>
            <br>
            <label>Product Description:</label>
            <br>
            <textarea type = "text" name = "description" value = "<?php echo htmlspecialchars($description) ?>"></textarea>
            <div class = "red-text"><?php echo $errors['description']; ?></div>
            <br>
            <label>Price:</label>
            <input type = "float" name = "price" value = "<?php echo htmlspecialchars($price) ?>">
            <div class = "red-text"><?php echo $errors['price']; ?></div>
            <br>
            <label>Category</label>
            <select name="category">
                    <option value="mensclothing">Men's Clothing</option>
                    <option value="womensclothing">Women's Clothing</option>
                    <option value="boysclothing">Boy's Clothing</option>
                    <option value="girlsclothing">Girl's Clothing</option>
                    <option value="infantclothing">Infant Clothing</option>
                    <option value="largeappliances">Large Appliances</option>
                    <option value="smallappliances">Small Appliances</option>
                    <option value="kitchenware">Kitchen Ware</option>
                    <option value="homeimprovement">Home Improvement</option>
                    <option value="homedecor">Home Decor</option>
                    <option value="furniture">Furniture</option>
                    <option value="toys">Toys</option>
                    <option value="electronics">Electronics</option>
                    <option value="media">Media (CD/DVD/Blu-Ray/Vinyl)</option>
                    <option value="books">Books/Magazines</option>
                    <option value="seasonal">Seasonal</option>
                    <option value="Other">Other</option>
                </select>
            <div class = "red-text"><?php echo $errors['description']; ?></div>
            <br>
            <form action="add.php" method="post" enctype="multipart/form-data">
            <label>Image:</label>
            <input type="file" name="image[]" />
            <br>
            <div>
            <br>
            <input type="submit" name="submit" value="Submit">
        </form>


</html>