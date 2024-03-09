<?php 
    include_once('Controller/LoginController.php');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="style/Login.css">

<?php
    function indexLogin() {
      $cont = new LoginController();
      $bool = $cont->Login($_POST["username"], $_POST["password"]);
      if (!$bool) {
        echo ("<script> alert('Failed to log in.');</script>");
      }
    }
    
    if (isset($_POST["submit"])) {
      indexLogin();
    }
?>
</head>
<body>
<!-- partial:index.partial.html -->
<form class="login" action="" method="post">
  
  <fieldset>
    
  	<legend class="legend">Login</legend>
    
    <div class="input">
    	<input type="text" id="username" name="username" placeholder="Username" required />
      <span><i class="fa fa-envelope-o"></i></span>
    </div>
    
    <div class="input">
    	<input type="password" id="password" name="password" placeholder="Password" required />
      <span><i class="fa fa-lock"></i></span>
    </div>
    
    <button type="submit" class="submit" name="submit" value="Login"><i class="fa fa-long-arrow-right"></i></button>
    
  </fieldset>
  
  <div class="feedback">
  	login successful <br />
    redirecting...
  </div>
  
</form>
<!-- partial -->
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="js/Login.js"></script>
  
</body>
</html>
