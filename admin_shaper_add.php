<?php 

require 'db.php';
require 'shaper_crud.php';
require 'profile_crud.php';

    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $userId = $_SESSION['userid'];

?>
<?php include 'css/loadBootstrap.html'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>LeBran - New Shaper</title>
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
  <li class="active"><a href="#">Create Shaper Record</a></li>
</ol>

<div class="container col-lg-12">
  <div class="panel panel-success">

    <div class="panel-heading">
      <h4> <span class="glyphicon glyphicon-plus"></span> Create Shaper Record </h4>    
    </div>

  <div class="panel-body">
   <form action="admin_shaper_add.php" method="post" autocomplete="off">
   
   <div class="row">     
      <div class="form-group col-md-4">
          <label for="record_date"> Record Date:  <span class="req"></span> </label>
          <input type="date" class="form-control" required name="record_date" >
      </div>
      <div class="form-group col-md-8">
          <label for="record_account"> Account:  <span class="req"></span> </label>
          <input type="text" required class="form-control" autocomplete="off" name='record_account' placeholder="Account" />
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12">      
          <label> CoShapers:  <span class="req"></span> </label>
          <table class="table table-responsive table-condensed table-striped" id="coShapersTable">
              <tr>
                  <th> <input type="checkbox"  /></th>
                  <th>Firstname</th>
                  <th>Lastname</th>                 
              </tr>
               <?php
               while ($row = mysqli_fetch_array($possibleCoShapers)) {
               ?>
                   <tr > 
                      <td><input type="checkbox"/>&nbsp;</td>
                      <td style="display:none;" class='coShaperID'><?php echo $row['id'];?></td>
                      <td><?php echo $row['first_name'];?></td>
                      <td><?php echo $row['last_name'];?></td>    
                                  
                   </tr>
              <?php  } ?>
          </table>
      </div>
    </div>
      <input type="hidden" id="record_coshapers" name="record_coshapers" value="" />

      <div class="row">
        <div class="form-group col-md-4">      
            <label for="record_remark"> Remarks:  <span class="req"></span> </label>
            <select class="form-control" name="record_remark">
                <?php foreach($remarks as $remark): ?>
                    <option value="<?= $remark['id']; ?>"><?= $remark['remarks_description']; ?></option>
                <?php endforeach; ?>
            </select>
          </div>
            <div class="form-group col-md-8">
              <label for="record_remark_add">Additional Remarks</label>
              <input type="text" class="form-control" name="record_remark_add" placeholder="Additional Remarks"/>
            </div>
      </div>

    <div class="row">  
      <div class="form-group col-md-4">      
          <label> Base:  <span class="req"></span> </label>
                  <input type="number" required autocomplete="off" id= "record_base" class="form-control" name='record_base' value = '1' oninput="CalculateFee()"/>
      </div>

      <div class="form-group col-md-4">      
          <label> Rate:  <span class="req"></span> </label>
                  <input type="number" required class="form-control" autocomplete="off" id= "record_rate" name='record_rate' value = '1' oninput="CalculateFee()"/>    
      </div>
      <div class="form-group col-md-4">      
          <label> Fee:  <span class="req"></span> </label>
                  <input type="number" readonly autocomplete="off" class="form-control" id= "record_fee" name='record_fee' value = '1'/>
      </div>
    </div>     
          
      <button type="submit" class="btn btn-success pull-right" id = "submitNewShaperRecord" name="submitNewShaperRecord" /><span class="glyphicon glyphicon-save"></span> Save</button>
          
    </form>
  </div>
</div>
</div>
</div>
  
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script>
     
    $('#submitNewShaperRecord').click(function(){
        var coShaperList = [];
        $('#coShapersTable').find('tr').each(function () {
        var row = $(this);
        if (row.find('input[type="checkbox"]').is(':checked')) {
            coShaperList.push(row.find('.coShaperID').html());
        }
        $('#record_coshapers').val(JSON.stringify(coShaperList)); 
    });
        
    });

    <?php include 'js/hidebutton.js' ?>
  </script>
  <script src="js/index.js"></script>

</body>
</html>
