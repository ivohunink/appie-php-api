<?php
	include("classes/Appie.class.php");

	$username = "";	
	$password = "";	
	$product = "";	
	$msg = "";

	if(isset($_GET["product"])
		&& isset($_GET["username"])
		&& isset($_GET["password"])
		){
			$username = $_GET["username"];
			$password = $_GET["password"];
			$product = $_GET["product"];
	
			$appie = new Appie();
			$appie->login($username,$password);

			if($appie->addProduct($product)) {
				$msg = "Product succesfully added";
			}
	}

?>
<!DOCTYPE html>
<html>
<body>
<script>
function toggle(id) {
    var x = document.getElementById(id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>
<pre>
  __   ____  ____  __  ____     ____  _  _  ____        __   ____  __  
 / _\ (  _ \(  _ \(  )(  __)___(  _ \/ )( \(  _ \ ___  / _\ (  _ \(  ) 
/    \ ) __/ ) __/ )(  ) _)(___)) __/) __ ( ) __/(___)/    \ ) __/ )(  
\_/\_/(__)  (__)  (__)(____)   (__)  \_)(_/(__)       \_/\_/(__)  (__) 
</pre>
<h2>Add a product to the Appie shopping list</h2>
<form action="" method="get">
	<label for="username">Appie Username</label><br>
	<input type="text" name="username" value="<?=$username?>"><br>
	<label for="password">Appie Password</label><br>
	<input type="text" name="password" value="<?=$password?>"><br>
	<label for="username">Product to add</label><br>
	<input type="text" name="product" value="<?=$product?>"><br>
	<input type="submit" value="Add product">
</form>
<h2><?=$msg?></h2>
</body>
</html>
