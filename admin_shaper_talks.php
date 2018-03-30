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

if (!empty($_POST)){
  $shaperId = $_POST['shaperId'];

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

    <div class="hideButton">
        <div class="navbar-header">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="glyphicon glyphicon-chevron-left" id="hideme"></i>
                <span id="hidemetext">Hide</span>
            </button>
        </div>
    </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
              <li><a href="#"><span class="glyphicon glyphicon-user"></span> Edit Profile</a></li>
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
      </div>

  <div class="container heading col-lg-12">
    <div class="panel panel-default">
        
        <div class="header panel-heading col-lg-12">
          <h4>Shaper Talks</h4>
        </div>

      <div class="panel-body">
        <br>
        <br>
        <br>
        <div class="form-group col-md-4">
          <input type="text" class="form-control" placeholder="Filter"/>
        </div>
        <div class="form-group col-md-2">
           <select class="form-control" name="sortByMonth">
            <?php
              echo '<option></option>'
            ?>
           </select>
         </div>
         <div class="form-group col-md-2">
          <button type="button" onclick="location.href = 'http://localhost/lebran/admin_shaper_talk_add.php';" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> New</button>
         </div>

          <table class="table table-responsive table-bordered">
            <thead>
              <th>Account</th>
              <th>Topic</th>
              <th>Speaker</th>
              <th>Fee</th>              
              <th></th>
            </thead>
            <tbody>
              <?php
                $shaperTalksRecord = $mysqli->query("SELECT * FROM SHAPER_TALKS");

                if(!$shaperTalksRecord)
                  trigger_error('Invalid query: ' . $mysqli->error);

                if ($shaperTalksRecord->num_rows > 0 ){  
                  echo '<form name="amendShaperTalk" method="post" action="admin_shaper_talk_modify.php">';
                 while($row = mysqli_fetch_array($shaperTalksRecord)){
                    echo '<tr>
                      <td data-comment-id='.$row["id"].' ></td>
                      <td>'.$row["account"].'</td>
                      <td>'.$row["topic"].'</td>                      
                      <td>'.$row["speaker"].'</td>
                      <td>'.$row["fee"].'</td>
                      ';

                     
                        echo'                        
                        <td><button class="btn btn-success" onclick="shaperRecord('.$row["id"].')"><span class="glyphicon glyphicon-edit"></span></button>
                        <button class="btn btn-danger" onclick=""><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                        </tr>';
                  }
                  echo  '<input type="hidden" name="shaperRecord" class="getShaperRecord" value=""/>
                  </form>';
                }
                else{
                  echo '<tr></tr>';
                }
              ?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
 <!-- Bootstrap Js CDN -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 <script type="text/javascript">
     $(document).ready(function () {
         $('#sidebarCollapse').on('click', function () {
             $('#sidebar').toggleClass('active');
             $('#hideme').toggleClass('glyphicon-chevron-left');
             $('#hideme').toggleClass('glyphicon-chevron-right');

             if($('#hideme').hasClass('glyphicon-chevron-left')){
              $('#hidemetext').text('Hide');
              $('#hideme').css('padding-left', '');
            }
            else{
              $('#hidemetext').text('Show');
              $('#hideme').css('padding-left', '20px');
            }
         });

         function shaperRecord(id){
            $('.getShaperRecord').val(id);
            console.log(id);
         }

        var value = $('.chooseShaper').val(<?php echo '' .$shaperId. '' ?>);
        console.log(value);

        if(value != ''){
          $('.shaperRecord').removeClass('hide');
        }
        else{
          $('.shaperRecord').addClass('hide');
        }

         <?php 
         if (!empty($_POST)){ ?>
          
          $('.chooseShaper').val(<?php echo '' .$shaperId. '' ?>);
          console.log(<?php echo ''.$shaperId.''?>);
          
         <?php } 
         ?>
     });
 </script>
</body>
</html>
