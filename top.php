<?php
ob_start();
session_start();
$error2 ='';
$error3 ='';
$success = '';
include("connect.php");
$c = 0;
if(isset($_SESSION['cart_array'])){
	$c = count($_SESSION['cart_array']);
}


// Registering user

if(isset($_POST['submit3'])){
    $registername = mysqli_real_escape_string($link,$_POST['registerName']);
    $registeremail = mysqli_real_escape_string($link,$_POST['registerEmail']);
    $registerPassword = mysqli_real_escape_string($link,$_POST['registerPassword']);
    $registerPhone = mysqli_real_escape_string($link,$_POST['registerPhone']);

    $check_mail = filter_var($registeremail,FILTER_VALIDATE_EMAIL);

    if(!$check_mail && strlen($registerPhone)!=10){
        $error2 = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Please enter a valid e-mail address.Enter a valid phone number.<a href="#register" data-toggle="modal">  Try again</a></strong>
                       </div>';
    }else if(strlen($registerPhone)!=10){
    	$error2 = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Please enter a valid phone number.<a href="#register" data-toggle="modal">  Try Again</a></strong>
                       </div>';
    }else if(!$check_mail){
    	$error2 = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Please enter a valid phone number.<a href="#register" data-toggle="modal">  Try Again</a></strong>
                       </div>';
    }


    else{

    $query3 = "INSERT INTO tmp_users(uName,uEmail,uPassword,uPhone,Date_of_register) VALUES('$registername','$registeremail','$registerPassword','$registerPhone',now())";
    $result3 = mysqli_query($link,$query3);

    if(!$result3){
        $error3= "Something went wrong there . Please try again!!!";
    }else{
        $success = '<div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Congratulations,you have been successfully registered.<a href="#login" data-toggle="modal">  Login</a></strong>
                    </div>';
    }

    }
}


// Checking username email and password

if(isset($_POST['submit2'])){
    $emailuser = mysqli_real_escape_string($link,$_POST['userEmail']);
    $passworduser = mysqli_real_escape_string($link,$_POST['userPassword']);

    $query2 = "SELECT * FROM tmp_users WHERE uEmail='$emailuser' AND uPassword = '$passworduser' ";
    if($result2 = mysqli_query($link,$query2)){
        $rows2 = mysqli_num_rows($result2);
        if($rows2==1){
            while($row2 = mysqli_fetch_array($result2)) {
                  $_SESSION['uname'] = $row2["uName"];
            }  
            header('Location:index.php');
        }else{
            $error2 = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Email or Password is incorrect.Try again!!!<a href="#login" data-toggle="modal">  Login</a></strong>
                       </div>';
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
    <script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript"> 

	function _(x){
		return document.getElementById(x);
	}

	function checkusername(){
		var cx = _("inputEmail").value;
		_("message").innerHTML = "Checking ..... ";
		var url = "myindex.php";
        var data = "contentVar=" + cx;
        var ajax = ajaxObj("POST",url);
		ajax.onreadystatechange = function(){
			if(ajaxReturn(ajax)==true){
				var response = ajax.responseText;
				_("message").innerHTML = response;
			}
		}

		ajax.send(data);
	}

	function checkphone(){
		var phone = _("inputPhone").value;
		_("message2").innerHTML = "Checking ..... ";
		var url = "myphone.php";
        var data = "phone=" + phone;
		var ajax = ajaxObj("POST",url);
		ajax.onreadystatechange = function(){
			if(ajaxReturn(ajax)==true){
				var response = ajax.responseText;
				_("message2").innerHTML = response;
			}
		}

		ajax.send(data);
	}


    </script>
</head>

<body>
	<div class="navbar navbar-inverse navbar-static-top " >
		<div class="container">

			<a href="index.php" class="navbar-brand">
			
			<p style="margin-right:20px;">Rent2Save</p>
			
			</a>
			
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>

			</button>	
			
			<div class="collapse navbar-collapse navHeaderCollapse">
				<ul class="nav navbar-nav navbar-center">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">About Us</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories<b class="caret"></b></a>
						<ul class="dropdown-menu">
	                        <li><a href="books.php">Books</a></li>
	                        <li><a href="#">Clothing</a></li>
	                        <li><a href="#">Previous Year Papers</a></li>
	                    </ul>
					</li>
					<li><a href="#">Offers</a></li>

	            </ul>
	            <a href="cart.php" class="navbar-btn btn-info btn navbar-right" id="uLogin" style="margin-left:8px;">
	              <span class="glyphicon glyphicon-shopping-cart"></span> <?php echo $c; ?>
	            </a>
                <?php
                if(isset($_SESSION['uname'])){
                	echo '<a href="userLogout.php" class="navbar-btn btn-info btn navbar-right" id="uLogin">Logout</a>';
                }
                else{
                	echo '<a href="#login" data-toggle="modal" class="navbar-btn btn-danger btn navbar-right">Login</a>';
                	echo '<a href="#register" data-toggle="modal" class="navbar-btn btn-success btn navbar-right" style="margin-right:8px;">Create Account</a>';
                }

                ?>
	            
	            

	        </div>    
	    
	    </div>
	</div>

    <p><?php echo $error2;?></p>
    <p><?php echo $success;?></p>
    <p><?php echo $error3;?></p>
	<div class="container">
		<div class="modal fade" id="login" role="dialog">
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
						      <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="userEmail">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
						    <div class="col-sm-10">
						      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="userPassword">
						    </div>
						  </div>
						  
						
		            </div>
		            <div class="modal-footer">

						<button type="submit" class="btn btn-info" name="submit2">Sign in</button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
		            </div>   
		            </form> 
		        </div>
		    </div>
		</div> 
		</div>

		<div class="container">
		<div class="modal fade" id="register" role="dialog">
			<div class="modal-dialog" style="width:800px;">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Create Account</h4>
		            </div>
		            <form class="form-horizontal" role="form" method="post">
		            <div class="modal-body">
						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="inputName" placeholder="Numbers and letters only" name="registerName" style="width:200px;">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
						    <div class="col-sm-10">
						      <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="registerEmail" style="width:200px;" onblur = "checkusername();">
						      <span id= "message"></span>
						    </div>
						  </div>
						  
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Phone Number</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control"  id="inputPhone"  placeholder="Phone Number" name="registerPhone" style="width:200px;" onblur = "checkphone();">
						      <span id= "message2"></span>
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
						    <div class="col-sm-10">
						      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="registerPassword" style="width:200px;">
						    </div>
						  </div>
						
		            </div>
		            <div class="modal-footer">

						<button type="submit" class="btn btn-info" name="submit3">Create Account</button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
		            </div>   
		            </form> 
		        </div>
		    </div>
		</div> 
		</div>
</body>
</html>

