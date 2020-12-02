<?php 
	include('config.php');
	// write query for all pizzas
	$sql = 'SELECT title, price, name, image FROM additem ORDER BY created_at';
	// get the result set (set of rows)
	$result = mysqli_query($link, $sql);
	// fetch the resulting rows as an array
	$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
	// free the $result from memory (good practise)
	mysqli_free_result($result);
	// close connection
	mysqli_close($link);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Online Garage Sale</title>
        <link rel="stylesheet" href="css/style.css">
        <!--Favicon-->
    </head>
    <body>
        <header>
            <h1 id="logo"><a href="index.html">OGS</a></h1>
            <h2 id="login"><a href="login_info/welcome.php">Login/Logout</a></h2>
            <h2 id="addlisting"><a href="Post a Listing/add.php">Post a Listing</a></h2>
            <h2 id="profile"><a href="profile.html">Profile</a></h2>
        </header>
        <aside>
            <ul>
                <li><a href="category.html">Men's Clothing</a></li>
                <li><a href="category.html">Women's Clothing</a></li>
                <li><a href="category.html">Boy's Clothing</a></li>
                <li><a href="category.html">Girl's Clothing</a></li>
                <li><a href="category.html">Infant Clothing</a></li>
                <li><a href="category.html">Large Appliances</a></li>
                <li><a href="category.html">Small Appliances</a></li>
                <li><a href="category.html">Kitchen</a></li>
                <li><a href="category.html">Home Improvement</a></li>
                <li><a href="category.html">Home Decor</a></li>
                <li><a href="category.html">Furniture</a></li>
                <li><a href="category.html">Toys</a></li>
                <li><a href="category.html">Electronics</a></li>
                <li><a href="category.html">Media</a></li>
                <li><a href="category.html">Books & Magazines</a></li>
                <li><a href="category.html">Seasonal</a></li>
                <li><a href="category.html">Misc.</a>></a></li>
            </ul>
        </aside>
        <div class="wrapper">
            <div class="box1">
                <h1>Search the Pile</h1>
            </div>
            <div class="box2">
                <?php foreach($items as $item): ?>
				<div class="col s6 m4">
					<div class="card z-depth-0">
						<div class="card-content center">
							<h5 style = "color:white">Product Name: <?php echo htmlspecialchars($item['title']); ?></h5>
                            <h6 style = "color:white">By: <?php echo htmlspecialchars($item['name']); ?></h6>
                            <h6 style = "color:white">Price: <?php echo htmlspecialchars($item['price']); ?></h6>
                            <form name="form1" action="" method="post" enctype="multipart/form-data">
                            <table>
                            <tr>
                            <td><input type="submit" name="submit2" value="display"></td>
                            </tr>
                            </table>
                            </form>
                            <?php
                            include('config.php');

                            if(isset($_POST["submit2"]))
                            {
                               $res=mysqli_query($link,"select image from additem");
                               echo "<table>";
                               echo "<tr>";
                               
                               while($row=mysqli_fetch_array($res))
                               {
                               echo "<td>"; 
                               echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image'] ).'" height="200" width="200"/>';
                               echo "<br>";
                               ?><a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a> <?php
                               echo "</td>";
                               } 
                               echo "</tr>";
                               
                               echo "</table>";
                              }
                            ?>
						</div>
						<div class="card-action right-align">
							<a class="brand-text" href="details.php?id=<?php echo $item['id'] ?>">more info</a>
						</div>
					</div>
				</div>
			    <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>