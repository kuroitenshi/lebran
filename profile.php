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
    <div class="panel panel-default">
        
        <div class="header panel-heading col-lg-12">
          <h4>My Shaper Record</h4>
        </div>

    <div class="shaperRecord panel-body">
        <div class="form-group col-md-4">
          <input type="text" class="form-control" placeholder="Filter"/>
        </div>
        <div class="form-group col-md-4">
           <select class="form-control" name="sortByMonth">
            <?php
              echo '<option></option>'
            ?>
           </select>
         </div>

          <table class="table table-responsive table-bordered">
            <thead>
              <th>Date</th>
              <th>Account</th>
              <th>Co-Shaper/s</th>
              <th>Remarks</th>
              <th>Base</th>
              <th>Rate</th>
              <th>Fee</th>
              <th>Deductions</th>
            </thead>
            <tbody>
              <?php
                $shaperRecord = $mysqli->query("SELECT * FROM shaper_record WHERE userId='$userId'");

                if(!$shaperRecord)
                  trigger_error('Invalid query: ' . $mysqli->error);

                if ($shaperRecord->num_rows > 0 ){  
                 while($row = mysqli_fetch_array($shaperRecord)){
                    echo '<tr>
                      <td>'.$row["date"].'</td>
                      <td>'.$row["account"].'</td>
                      ';

                      $coshapers = $mysqli->query("SELECT first_name FROM users as users INNER JOIN coshaper_map as coshaper WHERE coshaper.userID = '$userId' and users.id = coshaper.coshaperUserID and coshaper.shaperID = 
                        " .$row["id"]. "");
                      $remarks = $mysqli->query("SELECT remarks_description from remarks where id=".$row["remarks"]);

                      if(!$coshapers)
                        trigger_error('Invalid query: ' . $mysqli->error);

                      else{
                        echo '<td>';
                        while($row2 = mysqli_fetch_array($coshapers)){
                          echo '' .$row2["first_name"]. '<br>';
                        }
                        echo '</td>';
                      }

                     if(!$remarks)
                        trigger_error('Invalid query: ' . $mysqli->error);

                      else{
                        echo '<td>';
                        while($row3 = mysqli_fetch_array($remarks)){
                          echo '' .$row3["remarks_description"]. '<br>';
                        }
                        echo '</td>';
                      }
                        echo'
                        <td>'.$row["base"].'</td>
                        <td>'.$row["rate"].'</td>
                        <td>'.$row["fee"].'</td> 
                        <td>'.$row["deduction"].'</td>
                        </tr>';
                  }
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

          $('.list-unstyled li:nth-child(2)').addClass('active');
     });
 </script>
</body>
</html>
