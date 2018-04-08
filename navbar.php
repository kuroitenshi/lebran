<?php 
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];;
$type = $_SESSION['type'];

if (isset($profileDetails['id']) == 1){
    if($profileDetails['level'] != null){
        $row = $mysqli->query("SELECT level_name, level_description from level where id = " .$profileDetails['level']);
        $profileRow = $row -> fetch_assoc();

        $levelName = $profileRow['level_name'];
        $levelDesc = $profileRow['level_description'];
    }
}

?>

 <nav id="sidebar">
        <div class="sidebar-header">
            <div class="imagehere"></div>
            <h3>Lebran</h3>
        </div>

        <ul class="list-unstyled components">
          <div class="userPanel">
            <div class="picture">
              <img src="profileImages/<?php echo $profileDetails['head_shot'] ?>" onerror="this.src='img/default-user.png';" width="50px" height="50px"/>
            </div>
            <h5><?php  echo '' .$first_name. ' ' .$last_name. ''; ?> </h5>
          </div>
            <?php if($type == 'admin'){?>
            <li>
                <a href="#" onclick="location.href = 'http://localhost/lebran/profileadmin.php';"><span class="glyphicon glyphicon-home">
                </span> Home</a>
            </li>
            <li>
                <a href="#" onclick="location.href = 'http://localhost/lebran/admin_shaper_talks.php';" >Schedule of Talks</a>
            </li>
            <li>
                <a href="#" onclick="location.href = 'http://localhost/lebran/admin_sched_accounts.php';" >Schedule of Accounts</a>
            </li>
            <?php } else {?>
             <li>
                <a href="#" onclick="location.href = 'http://localhost/lebran/profile.php';"><span class="glyphicon glyphicon-home">
                </span> Home</a>
            </li>
            <?php } ?>
        </ul>

        <ul class="list-unstyled CTAs">
            <li><span class="label label-success"><span class="glyphicon glyphicon-object-align-bottom"></span>  Position</span> <span class="label label-default"><?php 
                if (isset($levelName) && isset($levelDesc)){
                    echo $levelName. ' - ' .$levelDesc;
                } 
                else {
                    echo 'Pending';
                } ?>
            </span></li>

            <li><span class="label label-success"><span class="glyphicon glyphicon-list"></span> Basic Information</span></li>

            <li><span class="glyphicon glyphicon-gift"></span> Birthday: <?php if ($profileDetails) echo date_format(date_create($profileDetails['birthday']),"M d Y"); else echo 'NA'; ?></li>
            <li><span class="glyphicon glyphicon-road"></span> Address: <?php if ($profileDetails) echo $profileDetails['address']; else echo 'NA'; ?></li>
        </ul>
      </nav>