<?php
include("top.php");
include("footer.php");


if(isset($_POST['pid'])){
	$pid = $_POST['pid'];
    $wasFound = false;
    $i = 0;

    if(!isset($_SESSION["cart_array"]) || count($_SESSION['cart_array']) < 1){

		$_SESSION['cart_array'] = array(0 => array("item_id" => $pid , "quantity" => 1));

	}else{

    	foreach($_SESSION['cart_array'] as $each_item){
    		$i++;
    		while(list($key,$value) = each($each_item)){
    			if($key == "item_id" && $value == $pid){
    				array_splice($_SESSION['cart_array'], $i-1,1,array(array("item_id" => $pid , "quantity" => $each_item["quantity"] + 1)));
    				$wasFound = true;
    			}// Close if condition
    		}// Close while loop
    	}// Close foreach loop

    	if($wasFound == false){
    		array_push($_SESSION['cart_array'], array("item_id" => $pid, "quantity" => 1));
    		
    	}

	}

	header("Location:cart.php");
}
?>

<?php

if(isset($_POST['item_to_adjust']) && $_POST['item_to_adjust']!=''){
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace("#[^0-9]#i", '', $quantity);
	if($quantity>=11){$quantity = 10;}
	if($quantity<1){$quantity = 1;}
    $i=0;
	foreach($_SESSION['cart_array'] as $each_item){
		$i++;
		while(list($key,$value) = each($each_item)){
			if($key == "item_id" && $value == $item_to_adjust){
				array_splice($_SESSION['cart_array'], $i-1,1,array(array("item_id" => $item_to_adjust , "quantity" =>$quantity)));
				$wasFound = true;
			}// Close if condition
		}// Close while loop
	}// Close foreach loop
}

?>

<?php

if(isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != ''){
	$key_to_remove = $_POST['index_to_remove'];
	if(count($_SESSION['cart_array']) <= 1){
		unset($_SESSION['cart_array']);
	}else{
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION['cart_array']);
		echo count($_SESSION['cart_array']);
	}

	header("Location:cart.php");
}

?>

<?php

/////////////////////////////////////////////////
//  Rendering the cart
////////////////////////////////////////////////
$total = 0;
$cartOutput = "";
if(!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1){
	$cartOutput = "<p style='text-align:center;'>Your shopping cart is empty</p>";
}else{
	$i = 0;
	foreach ($_SESSION['cart_array'] as $each_item) {
		
		$item_id = $each_item['item_id'];
		
		$cartOutput .='<div class="row">';
		
		$cartOutput .='<div class="col-md-4">';
		$cartOutput .='<img src="gallery/images/'.$item_id.'.jpg" style="width:100px;"></img>';
        $cartOutput .= '</div>';
		
		$query = "SELECT * FROM products WHERE id = '$item_id'";
		$result = mysqli_query($link,$query);
		while($row = mysqli_fetch_array($result)){
			$name = $row['pName'];
			$author = $row['Author'];
			$price = $row['price'];
		}
        
        $price =  $price * $each_item['quantity'];
        
        $cartOutput .='<div class="col-md-8">';
        $cartOutput .='<div class="col-md-2">';
        $cartOutput .= $each_item['item_id'];
        $cartOutput .= '</div>';
        $cartOutput .='<div class="col-md-5" style="text-align:center;">';
        $cartOutput .= $name;
        $cartOutput .= '</div>';
        $cartOutput .='<div class="col-md-2" style="text-align:center;">';
        $cartOutput .= '<form action="cart.php" method="post">
                        <div>
                        <input type="text" style= "width:30px;" name="quantity" maxlength="2" value="'.$each_item["quantity"].'"/>
                        <button type ="submit" name = "adjustBtn' .$item_id.'"><span class="glyphicon glyphicon-pencil"></span></button>
                        <input type="hidden" name="item_to_adjust" value="'. $item_id .'"/>
                        </div>
                        </form>';
        $cartOutput .= '</div>';
        $cartOutput .='<div class="col-md-2" style="text-align:center;">';
        $cartOutput .= 'Rs.' . number_format($price,1);
        $cartOutput .= '</div>';
        $cartOutput .='<div class="col-md-1" style="text-align:center;">';
        $cartOutput .= '<form action="cart.php" method="post">
                        <input type ="submit" class="remove" name = "deleteBtn' .$item_id.'"/>
                        <input type="hidden" name="index_to_remove" value="'. $i .'"/>
                        </form>';
        $cartOutput .= '</div>';
        $cartOutput .= '</div>';
        $cartOutput .= '</div>';
		$cartOutput .= '<hr>';
		$i++;
		$total = $total + $price;

		
	}
	
	$total =number_format($total,1);

}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <style type="text/css">
    .remove{

    background-image:url("images/cross.png");
    background-repeat:no-repeat;
    width:16px;
    height:16px;
    cursor:pointer;
    background-color:transparent;
    border:none;
    overflow: hidden;
    line-height: 3;
    }
    </style>
</head>

<body>
	<div class="container">
	<div class="row">
	  <div class="col-md-4"></div>
	  <div class="col-md-8">
	  	<div class="col-md-2">Id</div>
	  	<div class="col-md-5" style='text-align:center;'>Item</div>
	  	<div class="col-md-2" style='text-align:center;'>Quantity</div>
	  	<div class="col-md-2" style='text-align:center;'>Subtotal</div>
        
	  </div>
	</div>	
	<hr>
	<p><?php echo $cartOutput; ?></p>
	<div><h3 class="pull-right">Estimated Total : Rs.<?php echo $total; ?></h3></div>
	<div style="margin-top:100px;">
	<a href="index.php"><button type="button" class="btn btn-danger">Continue Shopping</button></a>
	<a href="#" class="pull-right"><button type="button" class="btn btn-success">Place Order</button></a>
    </div></div>    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>