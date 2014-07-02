<?php
ob_start();

require("top.php");
include("footer.php");

require("gallery/Gallery.php");

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


<div class="container">
	<div class="jumbotron">

         <center>
         	<h1>Welcome to Rent 2 Save</h1>
            <p>We offer rent options for the books and other materials that are used in Delhi Technological University . Get the free delivery of your books anywhere within the college campus itself without going anywhere.Just sit back and order from the comfort of your home.</p>
            <a href="#" class="btn btn-default">Order now !!!</a>
            <a href="#" class="btn btn-info">Know More</a>

         </center>

    </div>

</div>

<div class="container">
	<div class="row">
		<?php
		foreach($images as $image): ?>
		<div class="col-md-4"><center><img  class="img-responsive" style="margin-bottom:20px;width:130px;" src="<?php echo $image['full'];?>"></img>
            <?php  
                 $front = explode('.',end(explode('/', $image['full'])));
                 $front_first = $front[0];
                 $query = "SELECT * FROM products WHERE id = '$front_first'";
                 $result = mysqli_query($link,$query);
                 while($row = mysqli_fetch_array($result)){
                 $id = $row['id'];   
                 $name =  $row['pName'];
                 $price = $row['price'];
            } ?>
            
            <p><a href="products.php?id=<?php echo $id;?>"><button type="button" class="btn btn-primary">Buy / Rent Now</button></a>
               
            <h5 style="color:#666;"><?php echo $name; ?></h5>
            <h5 style="color:#666">Rs.<?php echo $price; ?></h5></center>
		</div>
		<?php endforeach; ?>
        
	</div>
</div>			
          
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/modify.js"></script>
</body>
</html>

