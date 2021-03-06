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
          <h4>Schedule of Talks</h4>
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
                  echo '<form id="amendShaperTalk" method="post" action="admin_shaper_talk_modify.php">';
                  $index = 0;
                 while($row = mysqli_fetch_array($shaperTalksRecord)){
                    echo '<tr>         
                      <td>'.$row["account"].'</td>
                      <td>'.$row["topic"].'</td>                      
                      <td>'.$row["speaker"].'</td>
                      <td>'.$row["fee"].'</td>
                      ';

                     
                        echo'                        
                        <td><button class="btn btn-success shaperTalkNum getShaperTalk'.$index.'" value="'.$row["id"].'"><span class="glyphicon glyphicon-edit"></span></button>
                        <button class="btn btn-danger shaperTalkNumDelete getShaperTalkDelete'.$index.'" value="'.$row["id"].'""><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                        </tr>';

                        $index++;
                  }
                  echo  '<input type="hidden" name="shaperTalkRecord" class="getShaperTalkRecord" value=""/>
                  <input type="hidden" name="shaperTalkRecordToDelete" class="getShaperTalkRecordToDelete" value=""/>
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
      var amendShaperTalkID;
      var deleteShaperTalkID;

      $(".shaperTalkNum").each(function (index, element){
          $( ".getShaperTalk" + index)
          .mouseover(function() {
            amendShaperTalkID = $('.getShaperTalk' + index).val();
          })
          .mouseout(function() {
            amendShaperTalkID = null;
          });
      });

      $(".shaperTalkNumDelete").each(function (index, element){
          $( ".getShaperTalkDelete" + index)
          .mouseover(function() {
            deleteShaperTalkID = $('.getShaperTalkDelete' + index).val();
          })
          .mouseout(function() {
            deleteShaperTalkID = null;
          });
      });

      $('#amendShaperTalk').submit(function() {
        if(amendShaperTalkID !== undefined && amendShaperTalkID !== null){
          $('.getShaperTalkRecord').val(amendShaperTalkID);
        }
       
        else if(deleteShaperTalkID != undefined && deleteShaperTalkID != null){
          $('.getShaperTalkRecordToDelete').val(deleteShaperTalkID);
       }
      });


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

          $('.list-unstyled li:nth-child(3)').addClass('active');
     });
 </script>
</body>
</html>
