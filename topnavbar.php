<?php
    
    $type = $_SESSION['type'];
?>

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
        <?php if($type == "admin") ?>
         <li><a href="manageprofile.php"><span class="glyphicon glyphicon-wrench"></span> Manage Profiles</a></li>
        <li><a href="editprofile.php"><span class="glyphicon glyphicon-user"></span> Edit Profile</a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
</div>