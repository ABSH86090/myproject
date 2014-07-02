<?php
ob_start();

include("top.php");
include("footer.php");

require("gallery/Gallery.php");

// Gallery to show the products

$gallery = new Gallery();
$gallery->setPath('gallery/images/');
$images = $gallery->getImages();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	  <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" /> 
</head>

<body>

<div style="margin-top:10px;">

<div style="width:15%;float:left;margin-left:20px;">	
<ul class="nav nav-pills nav-stacked" style="border:1px solid #428bca;border-radius:5px;">
  <li><a href="#">Home</a></li>
  <li class="active"><a href="#" style="border-radius:0px;">Profile</a></li>
  <li><a href="#">Messages</a></li>
</ul>

<ul class="nav nav-pills nav-stacked" style="border:1px solid #428bca;border-radius:5px;margin-top:5px;">
  <li><a href="#">Home</a></li>
  <li><a href="#" style="border-radius:0px;">Profile</a></li>
  <li class="active"><a href="#">Messages</a></li>
</ul>

<ul class="nav nav-pills nav-stacked" style="border:1px solid #428bca;border-radius:5px;margin-top:5px;">
  <li><a href="#">Home</a></li>
  <li><a href="#" style="border-radius:0px;">Profile</a></li>
  <li class="active"><a href="#">Messages</a></li>
</ul>

</div>
<div style="float:right;width:80%;">
	<button type="button" class="btn btn-warning btn-lg">
	  <span class="glyphicon glyphicon-book"></span> Books
	</button>
	<div style="margin-top:15px;">
	<div class="row">
		<?php
		foreach($images as $image): ?>
		<div class="col-md-4"><center><img  class="img-responsive" style="margin-bottom:20px;" src="<?php echo $image['full'];?>"></img>
            <?php  
                 $front = explode('.',end(explode('/', $image['full'])));
                 $front_first = $front[0];
                 $query = "SELECT * FROM products WHERE id = '$front_first'";
                 $result = mysqli_query($link,$query);
                 while($row = mysqli_fetch_array($result)){
                 $name =  $row['pName'];
                 $price = $row['price'];
            } ?>
            
            <p><button type="button" class="btn btn-primary">Buy Now</button>
               <button type="button" class="btn btn-success">Rent Now</button></p>
            <h5 style="color:#666;"><?php echo $name; ?></h5>
            <h5 style="color:#666">Rs.<?php echo $price; ?></h5></center>
		</div>
		<?php endforeach; ?>
        
	</div>
</div>		
</div>
		
         
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/modify.js"></script>
</body>
</html>