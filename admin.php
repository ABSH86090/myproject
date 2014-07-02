<?php
ob_start();

include("top.php");
include("footer.php");
include("connect.php");
if(!isset($_SESSION['aname'])){
  header("Location:index.php");
}

// Checking to make sure that this admin session value is in fact in the database

$adminId = preg_replace('#[^0-9]#i', '', $_SESSION['aid']);
$adminName = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION['aname']);
$adminEmail = preg_replace('#[^A-Za-z@.0-9]#i', '', $_SESSION['aemail']);
$adminPassword = preg_replace('#[^A-Za-z0-9@!]#i', '', $_SESSION['apassword']);

$query = "SELECT * FROM admin WHERE aEmail='$adminEmail' AND aPassword = '$adminPassword' AND id = '$adminId' AND aName = '$adminName'";
    if($result = mysqli_query($link,$query)){
        $rows = mysqli_num_rows($result);
        if($rows==0){
            header('Location:index.php');
            exit();
        }
    }

// Submitting the form     


if(isset($_POST['submit'])){
     
    // Insert the product details into the table

     $name = mysqli_real_escape_string($link,$_POST['name']);
     $category = mysqli_real_escape_string($link,$_POST['category']);
     $subCategory = mysqli_real_escape_string($link,$_POST['subCategory']);
     $price = mysqli_real_escape_string($link,$_POST['price']);
     $author = mysqli_real_escape_string($link,$_POST['author']);
     $query = "INSERT INTO products(pName,price,pCategory,pSubCategory,author) VALUES ('$name',$price,'$category','$subCategory','$author')";
     $result = mysqli_query($link,$query);
     if(!$result){
      echo "Something went wrong.Please try again."
     }
    // Uploading the image of prodducts

     $file_name = $_FILES['file']['name'];
     $tmp_name = $_FILES['file']['tmp_name'];

    if(isset($file_name)) {
     $pid = mysqli_insert_id($link);
     $newName = "$pid.jpg";
     move_uploaded_file($tmp_name, "gallery/images/$newName");
    }else{
      echo "Please choose a file name.";
    }
}

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
     <h3 style="margin-bottom:30px;"><?php echo "Welcome " . $_SESSION['aname'] ;?></h3>
     <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
       <div class="form-group">
         <label for="inputEmail3" class="col-sm-2 control-label">Product Name</label>
         <div class="col-sm-10">
           <input type="text" class="form-control" id="inputEmail3" name="name">
         </div>
       </div>
       <div class="form-group">
         <label for="inputEmail3" class="col-sm-2 control-label">Price</label>
         <div class="col-sm-10">
           <input type="number" class="form-control" id="inputEmail3" name="price">
         </div>
       </div>
       <div class="form-group">
         <label for="inputPassword3" class="col-sm-2 control-label">Category</label>
         <div class="col-sm-10">
           <input type="text" class="form-control" id="inputPassword3" name="category">
         </div>
       </div>
       <div class="form-group">
         <label for="inputPassword3" class="col-sm-2 control-label">Sub-Category</label>
         <div class="col-sm-10">
           <input type="text" class="form-control" id="inputPassword3" name="subCategory">
         </div>
       </div>
       <div class="form-group">
         <label for="inputPassword3" class="col-sm-2 control-label">Author</label>
         <div class="col-sm-10">
           <input type="text" class="form-control" id="inputPassword3" name="author">
         </div>
       </div>
       
       <div class="form-group" >
         <label for="inputEmail3" class="col-sm-2 control-label" style="margin-top:20px;">Choose a File</label>
         <div class="col-sm-10">
           <input type="file" name="file" style="margin-top:20px;" value="Browse">
         </div>
       </div>
       <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10">
           <button type="submit" class="btn btn-success" name="submit" style="margin-top:20px;">Add Product</button>
         </div>
       </div>
     </form>
  </div>
</form>

</div>	
	


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

