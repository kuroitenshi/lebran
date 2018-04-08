<?php 

require 'db.php';
require 'shaper_talk_crud.php';
require 'profile_crud.php';
include 'css/loadBootstrap.html'
?>
<!DOCTYPE html>
<html>
<head>
  <title>LeBran - Shaper Talks</title>
</head>

<body>
<div class="wrapper">

<?php include 'navbar.php' ?>

<div id="content">
<?php include 'topnavbar.php' ?>

<ol class="breadcrumb">
    <li><a href="admin_shaper_talks.php">Schedule Talk</a></li>
    <li class="active"><a href="#">Create Schedule</a></li>
</ol>

<div class="container col-lg-12">
    <div class="panel panel-success">

    <div class="panel-heading">
       <h4> <span class="glyphicon glyphicon-plus"></span> Create Schedule </h4> 
    </div>

        <div class="panel-body">   
            <form action="admin_shaper_talk_add.php" method="post" autocomplete="off">
               <div class="row">         
                    <div class="form-group col-md-12">
                        <label> Account:  <span class="req"></span> </label>
                          <input type="text" class="form-control" required name="talk_account" >
                    </div>
                    <div class="form-group col-md-12">
                        <label> Topic:  <span class="req"></span> </label>
                                <input type="text" class="form-control" autocomplete="off" name='talk_topic' />
                    </div>
                    <div class="form-group col-md-12">
                        <label> Speaker:  <span class="req"></span> </label>
                                <input type="text" class="form-control" autocomplete="off" name='talk_speaker' />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">      
                        <label> Fee:  <span class="req"></span> </label>
                                <input type="number" required class="form-control" autocomplete="off" id= "talk_fee" name='talk_fee' value = '1'/>
                    </div>
                </div>

            <div class="row">
                <button type="submit" class="btn btn-success col-md-2 pull-right right" id = "submitNewShaperTalk" name="submitNewShaperTalk" />Save</button>
                <button type="button" class="btn btn-default col-md-2 pull-right" onclick="location.href='admin_shaper_talks.php'" />Cancel</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>

</div>
  
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="js/hideButton.js"></script>

</body>
</html>
