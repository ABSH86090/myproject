<?php

include("top.php");
include("footer.php");

if(isset($_GET['id'])){
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']);
	$query = "SELECT * FROM products WHERE id = '$id'";
	$result = mysqli_query($link,$query);
	$count_rows = mysqli_num_rows($result);
	if($count_rows == 1){
		while($row = mysqli_fetch_array($result)){
			$productName = $row['pName'];
			$price = $row['price'];
			$author = $row['Author'];
		}
	}
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <title><?php echo $productName;?></title>
    <style type="text/css">
   .pic{
   	width:180px;
   	height:240px;
   }

   .picbig{
       position:absolute;
   	   width:0px;
   	   margin-left:150px;
   	   -webkit-transition:width 0.3s linear 0s;
   	   transition:width 0.3s linear 0s;
   	   z-index:10;
   }

   .pic:hover + .picbig{
       width:300px;
   }
    </style>

</head>

<body>

<div class="container">
	
    <div class="row">
      <div class="col-md-8">
      	<h2><p><?php echo $productName;?></p></h2>
      	<p>by <?php echo $author;?></p>
      </div>
      <div class="col-md-4"></div>
    </div>
	<div class="row" style="margin-top:50px;">
		
		<div class="col-md-4">

			<img src="gallery/images/<?php echo $id;?>.jpg" class="pic"></img>
			<img src="gallery/images/<?php echo $id;?>.jpg" class="picbig"></img>

        </div>
        <div class="col-md-8">

           <p><?php echo $productName;?></p>
           <h2>Rs.<?php echo $price;?></h2>
           <br/><br/><br/></br/><br/><br/>
           <form action="cart.php" method="post" id="form1">
           <input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>" />
           <input type="submit" name = "button" class="btn btn-success" value = "Add to Cart" style="width:200px;">
           <form>
        </div>
        
	</div>
</div>			
          
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/modify.js"></script>
</body>
</html>
