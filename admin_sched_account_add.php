<?php 

require 'db.php';
require 'account_crud.php';
require 'profile_crud.php';
include 'css/loadBootstrap.html'
?>
<!DOCTYPE html>
<html>
<head>
  <title>LeBran - Schedule of Account</title>
</head>

<body>
<div class="wrapper">

<?php include 'navbar.php' ?>

<div id="content">
<?php include 'topnavbar.php' ?>

<ol class="breadcrumb">
    <li><a href="admin_sched_accounts.php">Schedule of Accounts</a></li>
    <li class="active"><a href="#">Create Schedule</a></li>
</ol>

<div class="container col-lg-12">
    <div class="panel panel-success">

    <div class="panel-heading">
       <h4> <span class="glyphicon glyphicon-plus"></span> Create Schedule </h4> 
    </div>

        <div class="panel-body">   
            <form action="admin_sched_account_add.php" method="post" autocomplete="off">
               <div class="row">         
                    <div class="form-group col-md-6">
                        <label> Account:  <span class="req"></span> </label>
                          <input type="text" class="form-control" required name="account" >
                    </div>
                    <div class="form-group col-md-6">
                        <label> Category:  <span class="req"></span> </label>
                                <input type="text" class="form-control" autocomplete="off" name='category' />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">      
                        <label> Shaper Assigned:  <span class="req"></span> </label>
                         <table class="table table-responsive table-condensed table-striped" id="shapersAssigned">
                          <tr>
                              <th> <input type="checkbox"/></th>
                              <th>Firstname</th>
                              <th>Lastname</th>                 
                          </tr>
                           <?php
                           while ($row = mysqli_fetch_array($shapersAssigned)) {
                           ?>
                               <tr > 
                                  <td><input type="checkbox"/>&nbsp;</td>
                                  <td style="display:none;" class='accountID'><?php echo $row['id'];?></td>
                                  <td><?php echo $row['first_name'];?></td>
                                  <td><?php echo $row['last_name'];?></td>    
                                              
                               </tr>
                          <?php  } ?>
                      </table>
                    </div>
                    <input type="hidden" id="record_account" name="record_accounts" value="" />

                    <div class="form-group col-md-6">      
                        <label> Head Assigned:  <span class="req"></span> </label>
                         <table class="table table-responsive table-condensed table-striped" id="headsAssigned">
                          <tr>
                              <th> <input type="checkbox"/></th>
                              <th>Firstname</th>
                              <th>Lastname</th>                 
                          </tr>
                           <?php
                           while ($row = mysqli_fetch_array($shapersAssigned2)) {
                           ?>
                               <tr > 
                                  <td><input type="checkbox"/>&nbsp;</td>
                                  <td style="display:none;" class='accountID'><?php echo $row['id'];?></td>
                                  <td><?php echo $row['first_name'];?></td>
                                  <td><?php echo $row['last_name'];?></td>    
                                              
                               </tr>
                          <?php  } ?>
                      </table>
                    </div>
                    <input type="hidden" id="record_head" name="record_heads" value="" />
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label> Level:  <span class="req"></span> </label>
                         <select class="form-control" name="level">
                             <?php foreach($levelList as $level): ?>
                                <option value="<?= $level['id']; ?>"><?php echo $level['level_name']. ' ' .$level['level_description']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label> Remarks:  <span class="req"></span> </label>
                        <select class="form-control" name="remarks">
                             <?php foreach($remarks as $remark): ?>
                                <option value="<?= $remark['id']; ?>"><?= $remark['remarks_description']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                        <label> Additional Remarks:  <span class="req"></span> </label>
                                <input type="text" class="form-control" autocomplete="off" name='additional_remarks' />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label> Base:  <span class="req"></span> </label>
                                <input type="number" class="form-control" autocomplete="off" name='base' />
                    </div>
                    <div class="form-group col-md-3">
                        <label> Rate:  <span class="req"></span> </label>
                                <input type="number" class="form-control" autocomplete="off" name='rate' />
                    </div>
                    <div class="form-group col-md-3">
                        <label> Shaper's Share:  <span class="req"></span> </label>
                                <input type="number" class="form-control" autocomplete="off" name='shapers_share' />
                    </div>
                    <div class="form-group col-md-3">
                        <label> Lebran's Share:  <span class="req"></span> </label>
                                <input type="number" class="form-control" autocomplete="off" name='lebrans_share' />
                    </div>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-success col-md-2 pull-right right" id = "submitNewAccountId" name="submitNewAccount" />Save</button>
                    <button type="button" class="btn btn-default col-md-2 pull-right" onclick="location.href='admin_sched_accounts.php'" />Cancel</button>
                </div>
        </form>
        </div>
    </div>
    </div>
</div>

</div>
  
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="js/hideButton.js"></script>
  <script>
     
    $('#submitNewAccountId').click(function(){
        var accountList = [];
        $('#shapersAssigned').find('tr').each(function () {
            var row = $(this);
            if (row.find('input[type="checkbox"]').is(':checked')) {
                accountList.push(row.find('.accountID').html());
            }
            $('#record_account').val(JSON.stringify(accountList)); 
        });

         var headList = [];
        $('#headsAssigned').find('tr').each(function () {
            var row = $(this);
            if (row.find('input[type="checkbox"]').is(':checked')) {
                headList.push(row.find('.accountID').html());
            }
            $('#record_head').val(JSON.stringify(headList));      
        });
    });

    </script>
</body>
</html>
