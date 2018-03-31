<?php 

require 'db.php';
require 'shaper_crud.php';
require 'profile_crud.php';
include 'css/loadBootstrap.html';
?>
<!DOCTYPE html>
<html>
<head>
  <title>LeBran - Update Shaper</title>
  <script lang="javascript">
        function CalculateFee()
        {
          var base = document.getElementById('record_base').value;
          var rate = document.getElementById('record_rate').value; 

           document.getElementById('record_fee').value=parseInt(base) * parseInt(rate);
        }
        
        
    
  </script>
</head>

<body>
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

  <ol class="breadcrumb">
    <li><a href="profileadmin.php">Shaper Record</a></li>
    <li class="active"><a href="#">Amend Shaper Record</a></li>
  </ol>

<div class="container col-lg-12">
  <div class="panel panel-success">

   <div class="panel-heading">
       <h4> <span class="glyphicon glyphicon-plus"></span> Amend Shaper Record </h4> 
  </div>

  <div class="panel-content">
   <form action="admin_shaper_modify.php" method="post" autocomplete="off">
        
    <div class="form-group">
        <label> Record Date:  <span class="req"></span> </label>
        <input type="date" required name="record_date" class="form-control" value = "<?php echo $shaperRecordToAmend['date']; ?>" >
    </div>
    <br>
    <div class="form-group">
        <label> Account:  <span class="req"></span> </label>
        <input type="text" required autocomplete="off" class="form-control" name='record_account' value = "<?php echo $shaperRecordToAmend['account']; ?>"/>
    </div>
    <br>
    <div class="form-group">      
        <label> CoShapers:  <span class="req"></span> </label>
        <table border="1" style="width:100%" id="coShapersTable">
            <tr>
                <th> <input type="checkbox"  /></th>
                <th>Firstname</th>
                <th>Lastname</th>                 
            </tr>

             <?php
              while ($row = mysqli_fetch_array($possibleCoShapers)) {
                echo ('<tr>');
                
                $isChecked = false;

                foreach ($shaperRecoredToAmendCoShapersQuery as $coShaper) {

                  if($row['id'] == $coShaper['userid']){
                    $isChecked = true;

                  }
                }

                if($isChecked){
                  echo ('<td><input type="checkbox"/ checked>&nbsp;</td>');
                }else{
                  echo ('<td><input type="checkbox"/ >&nbsp;</td>');
                }
                  echo ('<td style="display:none;" class="coShaperID">'.$row['id'].'</td>');
                  echo ('<td>'.$row['first_name'].'</td>');
                  echo ('<td>'.$row['last_name'].'</td>');
                  echo ('</tr>');    
                } 
             ?>
             
        </table>
    </div>
    <input type="hidden" id="record_coshapers" name="record_coshapers" value="" />
    <br>
    <div class="field-wrap">      
        <label> Remarks:  <span class="req"></span> </label>
        <select name="record_remark">
        <?php
           
            foreach ($remarks as $remark) {
                if ($remark['id'] == $shaperRecordToAmendRemark['id']) {
                    echo('<option selected="selected" value='.$remark['id'].'>'.$remark['remarks_description'].'</option>');
                } else {
                    echo('<option value='.$remark['id'].'>'.$remark['remarks_description'].'</option>');
                }
            }
        ?>
        </select>
    </div>
    <br>

    <div class="field-wrap">      
        <label> Base:  <span class="req"></span> </label>
                <input type="number" required autocomplete="off" id= "record_base" name='record_base' value = "<?php echo $shaperRecordToAmend['base']; ?>" oninput="CalculateFee()"/>
    </div>
    <br>

    <div class="field-wrap">      
        <label> Rate:  <span class="req"></span> </label>
                <input type="number" required autocomplete="off" id= "record_rate" name='record_rate' value = "<?php echo $shaperRecordToAmend['rate']; ?>" oninput="CalculateFee()"/>    
    </div>
    <br>

    <div class="field-wrap">      
        <label> Fee:  <span class="req"></span> </label>
                <input type="number" readonly autocomplete="off" id= "record_fee" name='record_fee' value = "<?php echo $shaperRecordToAmend['fee']; ?>"/>
    </div>

    <br>     
          
      <button type="submit" class="button" id = "updateShaperRecord" name="updateShaperRecord" />Save</button>
          
    </form>
  </div>
</div>
</div>
 
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script>
     
    $('#updateShaperRecord').click(function(){
        var coShaperList = [];
        $('#coShapersTable').find('tr').each(function () {
        var row = $(this);
        if (row.find('input[type="checkbox"]').is(':checked')) {
            coShaperList.push(row.find('.coShaperID').html());
        }
        $('#record_coshapers').val(JSON.stringify(coShaperList)); 
    });
        
    });
  </script>
  <script src="js/index.js"></script>

</body>
</html>
