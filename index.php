<?php 
/* Main page with two forms: sign up and log in */
require 'db.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sign-Up/Login Form</title>
  <?php include 'css/css.html'; ?>
</head>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['login'])) { //user logging in

        require 'login.php';
        
    }
    
    elseif (isset($_POST['register'])) { //user registering
        
        require 'register.php';
        
    }
}
?>
<body>
  <div class="form">
      
      <ul class="tab-group">
        <li class="tab"><a href="#signup">Sign Up</a></li>
        <li class="tab active"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">

         <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form action="index.php" method="post" autocomplete="off">
          
            <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email" required autocomplete="off" name="email"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="password"/>
          </div>
          
          <p class="forgot"><a href="forgot.php">Forgot Password?</a></p>
          
          <button class="button button-block" name="login" />Log In</button>
          
          </form>

        </div>
          
        <div id="signup">   
          <h1>Sign Up</h1>
          
          <form action="index.php" method="post" autocomplete="off" enctype="multipart/form-data">
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name='firstname' />
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name='lastname' />
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name='email' />
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name='password'/>
          </div>

          <div class="field-wrap">
            <label for="address" >Address<span class="req">*</span></label>
            <input type="text" required autocomplete="off" name="address"/>
          </div>

          <div class="field-wrap">
            <h3>Birthday</h3>
            <input type="date"  required name="birthday"/>
          </div>
          
          <div class="field-wrap">
            <h3>Upload Profile Photo</h3>
            <input type="file" size="60" accept="image/*" name="profilePhoto" id = "profilePhoto"/>            
          </div>

          <div class="field-wrap">
            <h3>BDO Account Details</h3>
          </div>

          <div class="field-wrap">
            <label for="accountName">Account Name</label>
            <input type="text" required name="accountName"/>
          </div>

          <div class="field-wrap">
            <label for="accountNumber">Account Number</label>
            <input type="text" required name="accountNumber"/>
          </div>
          
          <button type="submit" class="button button-block" name="register" />Register</button>
          
          </form>

        </div>  
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script>
    $("document").ready(function(){

      $("#profilePhoto").change(function() {
          
      });
    });
  </script>
  <script src="js/index.js"></script>

</body>
</html>
