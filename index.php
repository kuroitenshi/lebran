<?php 
/* Main page with two forms: sign up and log in */
require 'db.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title> LeBran - Welcome! </title>
  <?php include 'css/loadBootstrap.html'; ?>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
<body class="lebranHomeBody" >


  <div class="container lebranHomeContainer">

    <div class="row">
      
      <div class="col-md-6 col-md-offset-3">

        <div class = "panel panel-default fade in lebranHomePanel">
          <div class="panel-heading"> <h1 style="text-align: center">LeBran (LOGO)</h1></div>
          <div class = "panel-body">
            <ul class="nav nav-tabs nav-justified">
              <li class="active"><a data-toggle="tab" href="#loginScreen">LOGIN</span></a></li>
              <li><a data-toggle="tab" href="#registerScreen">SIGN IN</a></li>
          
            </ul>
            <div class="tab-content">
              <div id="loginScreen" class="tab-pane fade in active">
                
              <br>
                <form action="index.php" method="post" autocomplete="off">
                  <div class="form-group">
                    
                    <label>
                      Email Address<span class="req">*</span>
                    </label>
                    <input type="email" class= "form-control" required autocomplete="off" name="email"/>
                
                  </div>
                  <div class="form-group">
                    <label>
                      Password<span class="req">*</span>
                    </label>
                    <input type="password" class = "form-control" required autocomplete="off" name="password"/>
                  
                  </div>
                      
                  <p class="forgot"><a href="forgot.php">Forgot Password?</a></p>
                  
                  <button class="col-md-12 btn btn-success center-block" name="login" />Login</button>
                  
                </form>
              </div>
              <div id="registerScreen" class="tab-pane fade">
          <br>
          <form action="index.php" method="post" autocomplete="off" enctype="multipart/form-data">
          <h5>Profile Details</h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>
                  First Name<span class="req">*</span>
                </label>
                <input type="text" class= "form-control" required autocomplete="off" name='firstname' />
              </div>

            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>
                  Last Name<span class="req">*</span>
                </label>
                <input type="text" class= "form-control" required autocomplete="off" name='lastname' />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>
                  Email Address<span class="req">*</span>
                </label>
                <input type="email" class= "form-control" required autocomplete="off" name='email' />
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label>
                  Password<span class="req">*</span>
                </label>
                <input type="password" class= "form-control" required autocomplete="off" name='password'/>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="address" >Address<span class="req">*</span></label>
            <input type="text" class= "form-control" required autocomplete="off" name="address"/>
          </div>

          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="birthday" >Birthday<span class="req">*</span></label>
                <input type="date" class= "form-control" required name="birthday"/>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="profilePhoto" >Profile Photo<span class="req">*</span></label>
                <input type="file" class= "form-control" size="30" accept="image/*" name="profilePhoto" id = "profilePhoto"/>            
              </div>
            </div>
          </div>

          <h5>BDO Account Details</h5>
          
          <div class="form-group">
            <label for="accountNumber">Account Number</label>
            <input type="text" class= "form-control" required name="accountNumber"/>
          </div>

          <div class="form-group">
            <label for="accountName">Account Name</label>
            <input type="text" class= "form-control" required name="accountName"/>
          </div>
            
          <button type="submit" class="col-md-12 btn btn-success center-block" name="register" />Register</button>                 
           
          </div>
          
          
          </form>
        </div>

          </div>
   
          <div class = "panel-footer">Copyright © 2018</div>
          </div>

        
        
        

    </div>
      </div>
      
    </div>
    

      
  </div>

  <script>
    $("document").ready(function(){

      $("#profilePhoto").change(function() {
          
      });
    });
  </script>
  <script src="js/index.js"></script>

</body>
</html>
