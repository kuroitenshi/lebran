<?php
/* Displays user information and some useful messages */
session_start();
require 'db.php';
require 'profile_crud.php';

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");    
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $userId = $_SESSION['userid'];
    $address = $profileDetails['address'];
    $accountNumber = $profileDetails['account_number'];
    $accountName = $profileDetails['account_name'];
    $birthday = $profileDetails['birthday'];

}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Welcome <?= $first_name.' '.$last_name ?></title>
  <?php include 'css/loadBootstrap.html'; ?>
</head>

<body>
  <!-- SIDE NAV BAR -->
 <div class="wrapper">
  <?php include 'navbar.php' ?>
  
  <div id="content">

    <?php include 'topnavbar.php' ?>

  <div class="container heading col-lg-12">
    <div class="panel panel-success">
        
        <div class="header panel-heading col-lg-12" style="margin-bottom:20px;">
          <h4><span class="glyphicon glyphicon-edit"></span> Edit Profile</h4>
        </div>

    <div class="panel-body">
        <form action="update_profile.php" method="post" autocomplete="off" enctype="multipart/form-data">
          <h5>Profile Details</h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>
                  First Name
                </label>
                <input type="text" class= "form-control" required autocomplete="off" 
                value="<?php echo $first_name ?>" name='firstname' />
              </div>

            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>
                  Last Name
                </label>
                <input type="text" class= "form-control" required autocomplete="off" 
                value="<?php echo $last_name ?>" name='lastname' />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>
                  Email Address
                </label>
                <input type="email" class= "form-control" required autocomplete="off" 
                value="<?php echo $email ?>" name='email' />
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label>
                  Password
                </label>
                <input type="password" class= "form-control" required autocomplete="off" 
                 name='password'/>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class= "form-control" required autocomplete="off" 
            value="<?php echo $address ?>" name="address"/>
          </div>

          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="birthday" >Birthday</label>
                <input type="date" class= "form-control" required name="birthday" value="<?php echo $birthday ?>"/>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="profilePhoto">Profile Photo</label>
                <input type="file" class= "form-control" size="30" accept="image/*" name="profilePhoto" id = "profilePhoto"/>            
              </div>
            </div>
          </div>

          <h5>BDO Account Details</h5>
          
          <div class="form-group">
            <label for="accountNumber">Account Number</label>
            <input type="text" class= "form-control" required 
            value="<?php echo $accountNumber ?>" name="accountNumber"/>
          </div>

          <div class="form-group">
            <label for="accountName">Account Name</label>
            <input type="text" class= "form-control" required name="accountName" value="<?php echo $accountName ?>"/>
          </div>
            
          <button type="submit" class="col-md-12 btn btn-success center-block" name="update_profile" />Update</button>                 
           
          </div>
          
          
          </form> 
    </div>
  </div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/hideButton.js"></script>
 <!-- Bootstrap Js CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 <script type="text/javascript">
  $('.userPanel').addClass('activeUser');
 </script>
</body>
</html>
