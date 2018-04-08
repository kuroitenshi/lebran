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
}

$manageUser = '';

if (isset($_POST['chooseUserBtn'])){
  $manageUser = $_POST['userselect'];
  $_SESSION['manageuser'] = $manageUser;

  $levelquery = $mysqli->query("SELECT level FROM profile where userID='$manageUser'");
  $db_levelid = $levelquery->fetch_assoc();

  $levelList = $mysqli->query("SELECT * FROM level");

}else if(isset($_POST['submitLevel'])){
  $levelfield = $_POST['level'];
  $query = "UPDATE profile set level = '$levelfield' where userID =".$_SESSION['manageuser'];
  if($mysqli->query($query)){
    $_SESSION['message'] = "<span class='glyphicon glyphicon-ok'></span> Update Successful!";
  }else{
    $_SESSION['message'] = "<span class='glyphicon glyphicon-remove'></span> Update Unsuccessful!";
  }

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
    <div class="row">
      <div class="alert alert-success alert-dismissible hide" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5><?php 
          if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
          }
          ?></h5>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading"><h4><span class="glyphicon glyphicon-wrench"></span> Manage User</h4></div>

      <div class="panel-body">
         <div class="form-group row col-md-12">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <div class="col-md-4">
            <label>User</label>
            <select name="userselect" class="form-control chooseUser">
              <option></option>
              <?php
                $users = $mysqli->query("SELECT * FROM users");

                while($userRow = mysqli_fetch_array($users)){
                  echo '<option value='.$userRow['id']. '>'.$userRow['first_name']. ' ' .$userRow['last_name'].'</option>';
                }
              ?>
            </select>
           </div>
          <div class="col-md-2">
            <button type="submit" name="chooseUserBtn" value="chooseuserbtn" style="margin-top:19px;" class="btn btn-success"><span class="glyphicon glyphicon-search"></span> Submit</button>
          </div>
           <div class="col-md-2 hide">
            <label>Name </label>
           </div>
            <div class="col-md-2 hide">
            <label>Level </label>
           </div>
          </div>
        </form>
      </div>
    </div>

    <div class="userRecord hide">
      <div class="panel panel-default">
          
          <div class="header panel-heading col-lg-12" style="margin-bottom: 20px;">
            <h4>User Record</h4>
          </div>

        <div class="panel-body">
          <form name="changeType" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Level</label>
                <select name="level" class="form-control">
                 <?php foreach($levelList as $level){
                   if ($level['id'] == $db_levelid['level']) {
                    echo('<option selected="selected" value='.$level['id'].'>'.$level['level_name']. ' ' .$level['level_description']. '</option>');
                    } else {
                      echo('<option value='.$level['id'].'>'.$level['level_name']. ' ' .$level['level_description']. '</option>');
                    }
                 } ?>
                </select>
            </div>

            <div class="col-md-2 pull-right">
              <button type="submit" name="submitLevel" value="submitlevel" class="col-md-12 btn btn-success"><span class="glyphicon glyphicon-ok"></span> Submit</button>
            </div>

          </form>         
          </div>
        </div>
      </div>
  </div>
  </div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
<script src="js/hideButton.js"></script>
 <!-- Bootstrap Js CDN -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 <script type="text/javascript">
     $(document).ready(function () {

        var value = $('.chooseUser').val(<?php if(!empty($manageUser)){
          echo '' .$manageUser. '';}
          else echo ''; ?>);
        console.log(value.val);

        if(value != ''){
          $('.userRecord').removeClass('hide');
        }
        else{
          $('.userRecord').addClass('hide');
        }

         <?php 
         if (!empty($_POST)){ ?>
          
          $('.chooseUser').val(<?php echo '' .$manageUser. '' ?>);
          console.log(<?php echo ''.$manageUser.''?>);
          
         <?php } 

          if(empty($_SESSION['message'])){
          ?>
          if($(".alert-success").hasClass("hide")){

          }
          else
            $(".alert-success").addClass("hide");

         <?php }else{ ?>
          if($(".alert-success").hasClass("hide")){
            $(".alert-success").removeClass("hide");


            <?php unset($_SESSION['message'])?>
          }

          <?php } ?>

         $('.userPanel').addClass('activeUser');
     });
 </script>
</body>
</html>
