<?php 
	include('config.php');
	// write query for all pizzas
	$sql = 'SELECT title, price, user, image FROM additem ORDER BY created_at';
    // get the result set (set of rows)

	    $result = mysqli_query($link, $sql);
	    // fetch the resulting rows as an array
	    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    // free the $result from memory (good practise)
        mysqli_free_result($result);
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
            <h1 id="logo"><a href="index.php">OGS</a></h1>
            <h2 id="login"><a href="login_info/welcome.php">Login/Logout</a></h2>
            <h2 id="addlisting"><a href="login_info/login.php">Post a Listing</a></h2>
        </header>
        <aside>
            <ul>
                <li><a href="category.html">Clothing</a></li>
                <li><a href="hard_code_cat.php">Appliances</a></li>
                <li><a href="category.html">Home</a></li>
                <li><a href="category.html">Toys</a></li>
                <li><a href="category.html">Electronics</a></li>
                <li><a href="category.html">Media</a></li>
                <li><a href="category.html">Seasonal</a></li>
                <li><a href="category.html">Misc.</a>></a></li>
            </ul>
        </aside>
        <div class="wrapperSTP">
            <?php foreach($items as $item): ?>
                <div class="box2">
					<div class="innerBox4">
                        <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($item['image']).'"height="200" width="200"/>';?>
						<h1><a class="brand-text" href="details.php?id=<?php echo $item['id'] ?>"><?php echo htmlspecialchars($item['title']); ?></a></h1>
                        <h2><a href="profile.html"><?php echo htmlspecialchars($item['user']); ?></a></h2>
                        <h3><?php echo htmlspecialchars($item['price']); ?></h3>
					</div>
			<?php endforeach; ?>
        </div>
    </body>
</html>