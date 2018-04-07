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
      <div class="panel-heading"><h4>Choose Shaper</h4></div>

      <div class="panel-body">
         <div class="form-group row col-md-12">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <div class="col-md-4">
            <label>Shaper</label>
            <select name="shaperId" class="form-control chooseShaper">
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
            <button type="submit" style="margin-top:19px;" class="btn btn-success"><span class="glyphicon glyphicon-search"></span> Submit</button>
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

  <div class="shaperRecord hide">
    <div class="panel panel-default">
        
        <div class="header panel-heading col-lg-12">
          <h4>Shaper Record</h4>
        </div>

      <div class="panel-body">
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
          <button type="button" onclick="location.href = 'http://localhost/lebran/admin_shaper_add.php';" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> New</button>
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
              <th></th>
            </thead>
            <tbody>
              <?php
                $shaperRecord = $mysqli->query("SELECT * FROM shaper_record WHERE userId='$shaperId'");

                if(!$shaperRecord)
                  trigger_error('Invalid query: ' . $mysqli->error);

                if ($shaperRecord->num_rows > 0 ){ 
                  echo '<form id="amendShaper" method="post" action="admin_shaper_modify.php">';
                  $index = 0;
                 while($row = mysqli_fetch_array($shaperRecord)){
                    echo '<tr>
                      <td>'.$row["date"].'</td>
                      <td>'.$row["account"].'</td>
                      ';

                      $coshapers = $mysqli->query("SELECT first_name FROM users as users INNER JOIN coshaper_map as coshaper WHERE coshaper.userID = '$shaperId' and users.id = coshaper.coshaperUserID and coshaper.shaperID = 
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
                        <td><button class="btn btn-success shaperNum getShaper'.$index.'" value="'.$row["id"].'"><span class="glyphicon glyphicon-edit"></span></button>
                        <button class="btn btn-danger shaperNumDelete getShaperDelete'.$index.'" value="'.$row["id"].'" id="deleteShaperRecord"><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                        </tr>';

                        $index++;
                  }
                  echo '<input type="hidden" name="shaperRecord" class="getShaperRecord" value=""/>
                  <input type="hidden" name="shaperRecordToDelete" class="getShaperRecordToDelete" value=""/>
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
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
 <!-- Bootstrap Js CDN -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 <script type="text/javascript">
  var amendShaperId;
  var deleteShaperTalkID;

    $(".shaperNum").each(function (index, element){
         $( ".getShaper" + index)
        .mouseover(function() {
          amendShaperId = $('.getShaper' + index).val();
        })
        .mouseout(function() {
          amendShaperId = null;
        });
    });

     $('#amendShaper').submit(function() {
      if(amendShaperId !== null && amendShaperId !== undefined)
        $('.getShaperRecord').val(amendShaperId);
      else if(deleteShaperTalkID !== null && deleteShaperTalkID !== undefined)
        $('.getShaperRecordToDelete').val(deleteShaperTalkID);
    });

    $(".shaperNumDelete").each(function (index, element){
        $( ".getShaperDelete" + index)
        .mouseover(function() {
          deleteShaperTalkID = $('.getShaperDelete' + index).val();
        })
        .mouseout(function() {
          deleteShaperTalkID = null;
        });
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

        var value = $('.chooseShaper').val(<?php if(isset($shaperId)) echo '' .$shaperId. ''; else echo ''; ?>);
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

          $('.list-unstyled li:nth-child(2)').addClass('active');
     });
 </script>
</body>
</html>
