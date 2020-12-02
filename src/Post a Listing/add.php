<?php 

    session_start();
    include('../config.php');

    $title = $description = $price = $name = $category = '';
    $errors = array('description' =>'', 'title' => '', 'price'=> '', 'name' => '', 'category' => '');

    if(isset($_POST['submit'])){

        //check title
        if(empty($_POST['title'])){
            $errors['title'] = 'a title is required <br />';
        } else{
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title'] = 'title must be letters and spaces only <br />';
            }
        }

        //check description
        if(empty($_POST['description'])){
            $errors['description'] = 'a description is required <br />';
        } else{
            $description = $_POST['description'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $description)){
                $errors['description'] = 'description must be letters and spaces only <br />';
            }
        }

        //check name
        if(empty($_POST['name'])){
            $errors['name'] = 'a name is required <br />';
        } else{
            $name = $_POST['name'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
                $errors['name'] = 'name must be letters and spaces only <br />';
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
            $name = mysqli_real_escape_string($link, $_POST['name']);
            $price = mysqli_real_escape_string($link, $_POST['price']);


            //create sql
            $sql = "INSERT INTO additem(title,description,name,price,image) VALUES('$title', '$description', '$name', '$price', '$NewImageName')";

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
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
        <header>
            <h1 id="logo"><a href="../index.html">OGS</a></h1>
            <h2 id="addlisting"><a href="add.php">Post a Listing</a></h2>
            <h2 id="profile"><a href="../profile.html">Profile</a></h2>
        </header>

        <form class = "white" action = "add.php" method = "POST">
            <label style = "display:block; font-family: Arial, Helvetica, sans-serif; color: white; font-size: 20pt;">Your Name:</label>
            <input type = "text" name = "name" value = "<?php echo htmlspecialchars($name) ?>">
            <div class = "red-text"><?php echo $errors['name']; ?></div>
            <br>
            <label style = "display:block; font-family: Arial, Helvetica, sans-serif; color: white; font-size: 20pt;">Product Title:</label>
            <input type = "text" name = "title" value = "<?php echo htmlspecialchars($title) ?>">
            <div class = "red-text"><?php echo $errors['title']; ?></div>
            <br>
            <label style = "display:block; font-family: Arial, Helvetica, sans-serif; color: white; font-size: 20pt;">Product Description:</label>
            <textarea type = "text" name = "description" value = "<?php echo htmlspecialchars($description) ?>"></textarea>
            <div class = "red-text"><?php echo $errors['description']; ?></div>
            <br>
            <label style = "display:block; font-family: Arial, Helvetica, sans-serif; color: white; font-size: 20pt;">Price:</label>
            <input type = "float" name = "price" value = "<?php echo htmlspecialchars($price) ?>">
            <div class = "red-text"><?php echo $errors['price']; ?></div>
            <br>
            <form action="add.php" method="post" enctype="multipart/form-data">
            <label style = "display:block; font-family: Arial, Helvetica, sans-serif; color: white; font-size: 20pt;">Image:</label>
            <input type="file" name="image[]" />
            <br>
            <div>
 <!--               <label>Category:</label>
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
            </div>
            <br>
-->
            <br>
            <input type="submit" name="submit" value="Submit">
        </form>


</html>