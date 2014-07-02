<?php

ob_start();

include("connect.php");

// Checking admin email and password

if(isset($_POST['submit'])){
	$email = mysqli_real_escape_string($link,$_POST['adminEmail']);
	$password = mysqli_real_escape_string($link,$_POST['adminPassword']);

    $query = "SELECT * FROM admin WHERE aEmail='$email' AND aPassword = '$password' ";
    if($result = mysqli_query($link,$query)){
        $rows = mysqli_num_rows($result);
        if($rows==1){
            while($row = mysqli_fetch_array($result)) {
                  $_SESSION['aname'] = $row["aName"];
                  $_SESSION['aemail'] = $row["aEmail"];
                  $_SESSION['aid'] = $row["id"];
                  $_SESSION['apassword'] = $row["aPassword"];
            }  
            header('Location:admin.php');
        }else{
            $error = "Incorrect email or password.Try again!!!!";
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
</head>

<body>
	<div class="navbar navbar-default navbar-fixed-bottom ">

	<div class="container">

	<p class="navbar-text pull-left">Copyright (c) r2s.in 2014</p>
	<?php
	if(isset($_SESSION['aname'])){
		echo '<a href="adminLogout.php" class="navbar-btn btn-warning btn navbar-right" id="aLogin">Logout</a>';
	}
	else{
		echo '<a href="#admin-login" data-toggle="modal" class="navbar-btn btn-warning btn navbar-right" id="aLogin">Admin-Login</a>';
	}

	?>
		
	</div>

	</div>
	<div class="container">
	<div class="modal fade" id="admin-login" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4>Login</h4>
	            </div>
	            <form class="form-horizontal" role="form" method="post">
	            <div class="modal-body">
					
					  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					    <div class="col-sm-10">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="adminEmail" >
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="adminPassword">
					    </div>
					  </div>
					  
					
	            </div>
	            <div class="modal-footer">

					<button type="submit" class="btn btn-info" name="submit">Sign in</button>
					<a class="btn btn-default" data-dismiss="modal">Close</a>
	            </div>   
	            </form> 
	        </div>
	    </div>
	</div> 
	</div>
</div>
</body>
</html>

