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
        
        <div class="header panel-heading col-lg-12">
          <h4>Schedule of Accounts</h4>
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
          <button type="button" onclick="location.href = 'http://localhost/lebran/admin_sched_account_add.php';" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> New</button>
         </div>

          <table class="table table-responsive table-bordered">
            <thead>
              <th>Account</th>
              <th>Category</th>
              <th>Shaper Assigned</th>
              <th>Head</th>              
              <th>Level</th>
              <th>Remarks</th>
              <th>Base</th>
              <th>Rates</th>
              <th>Shaper's Share</th>
              <th>Lebran's Share</th>
              <th></th>
            </thead>
            <tbody>
              <?php
                $accountRecords = $mysqli->query("SELECT * FROM ACCOUNT");

                if(!$accountRecords)
                  trigger_error('Invalid query: ' . $mysqli->error);

                if ($accountRecords->num_rows > 0 ){  
                  echo '<form id="amendAccSched" method="post" action="admin_sched_account_modify.php">';
                  $index = 0;
                 while($row = mysqli_fetch_array($accountRecords)){
                  
                  $shapersAssigned = $mysqli->query("SELECT first_name, last_name FROM users inner join shaper_map where shaper_map.account_id = ".$row["id"]. " and shaper_map.user_id = users.id");
                  $headAssigned = $mysqli->query("SELECT first_name, last_name FROM users inner join head_map where head_map.account_id = ".$row["id"]. " and head_map.user_id = users.id");
                  $levelList = $mysqli->query("SELECT * FROM level WHERE id=" .$row["level"]);
                  $remarks = $mysqli->query("SELECT * FROM remarks WHERE id=" .$row["remarks"]);

                    echo '<tr>         
                      <td>'.$row["name"].'</td>
                      <td>'.$row["category"].'</td>';

                      if($shapersAssigned->num_rows != 0){
                        echo '<td>';
                        while($row2 = mysqli_fetch_array($shapersAssigned)){                    
                          echo $row2["first_name"]. ' ' .$row2["last_name"]. '<br>';
                        }
                        echo '</td>';
                      }
                      else
                        echo '<td></td>';

                      if($headAssigned->num_rows != 0){
                        echo '<td>';
                        while($row2 = mysqli_fetch_array($headAssigned)){                    
                          echo $row2["first_name"].' '.$row2["last_name"]. '<br>';
                        }
                        echo '</td>';
                      }
                      else
                        echo '<td></td>';

                      echo '<td>';
                        while($row2 = mysqli_fetch_array($levelList)){                    
                          echo $row2["level_name"].' '.$row2["level_description"]. '<br>';
                        }
                      echo '</td>';
                    
                    echo'<td>'; 
                    while($row2 = mysqli_fetch_array($remarks)){                    
                          echo $row2["remarks_description"].' ';
                    }
                    echo  $row['additional_remarks'].'</td>
                    <td>'.$row["base"].'</td>
                    <td>'.$row["rate"].'</td>
                    <td>'.$row["shapers_share"].'</td>
                    <td>'.$row["lebrans_share"].'</td>                            
                    <td><button class="btn btn-success accountSched getAccountSched'.$index.'" value="'.$row["id"].'"><span class="glyphicon glyphicon-edit"></span></button>
                    <button class="btn btn-danger accountSchedDelete getAccountSchedDelete'.$index.'" value="'.$row["id"].'""><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                    </tr>';

                    $index++;
                  }
                  echo  '<input type="hidden" name="accountSchedRecord" class="getAccountSchedRecord" value=""/>
                  <input type="hidden" name="accountSchedRecordToDelete" class="getAccountSchedRecordToDelete" value=""/>
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
<script src="js/hideButton.js"></script>
 <!-- Bootstrap Js CDN -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 <script type="text/javascript">
      var amendSchedAccount;
      var deleteSchedAccount;

      $(".accountSched").each(function (index, element){
          $( ".getAccountSched" + index)
          .mouseover(function() {
            amendSchedAccount = $('.getAccountSched' + index).val();
          })
          .mouseout(function() {
            amendSchedAccount = null;
          });
      });

      $(".accountSchedDelete").each(function (index, element){
          $( ".getAccountSchedDelete" + index)
          .mouseover(function() {
            deleteSchedAccount = $('.getAccountSchedDelete' + index).val();
          })
          .mouseout(function() {
            deleteSchedAccount = null;
          });
      });

      $('#amendAccSched').submit(function() {
        if(amendSchedAccount !== undefined && amendSchedAccount !== null){
          $('.getAccountSchedRecord').val(amendSchedAccount);
        }
       
        else if(deleteSchedAccount != undefined && deleteSchedAccount != null){
          $('.getAccountSchedRecordToDelete').val(deleteSchedAccount);
       }
      });


     $(document).ready(function () {

         <?php

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

          $('.list-unstyled li:nth-child(4)').addClass('active');
     });
 </script>
</body>
</html>
