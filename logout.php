<?php
/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Error</title>
  <?php include 'css/loadBootstrap.html'; ?>
</head>

<body>

	<div class="lebranHomeContainer">
	<div class="col-md-6 col-md-offset-3">
	    <div class="panel panel-default fade in lebranHomePanel"">

	    	<div class="panel-body">
	          <h1>Thanks for stopping by</h1>
	              
	          <p><?= 'You have been logged out!'; ?></p>
	          
	          <a href="index.php"><button class="btn btn-default"/>Home</button></a>
	         </div>

	    </div>
	</div>
	</div>
</body>
</html>
