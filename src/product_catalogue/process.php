<?php include 'database.php';

// create a variable
$title=$_POST['title'];
$description=$_POST['desc'];
$category=$_POST['category'];
$price=$_POST['price'];
$user=$_POST['user'];

//Execute the query
mysqli_query($connect,"INSERT INTO products (title, desc, category, price, user)
		        VALUES ('$title','$desc','$category','$price', '$user')");
				
	if(mysqli_affected_rows($connect) > 0){
	echo "<p>Product Added</p>";
	echo "<a href="index.php">Go Back</a>";
} else {
	echo "Product NOT Added<br/>";
	echo mysqli_error ($connect);
}

?>