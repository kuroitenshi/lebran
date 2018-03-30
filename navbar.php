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

            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"><span class="glyphicon glyphicon-home">
                </span> Home</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li><a href="#"><span class="glyphicon glyphicon-file"></span> My Record</a></li>
                </ul>
            </li>
            <li>
                <a href="#" onclick="location.href = 'http://localhost/lebran/admin_shaper_talks.php';" >Shaper Talks</a>
            </li>
            <li>
                <a href="#">Contact</a>
            </li>
        </ul>

        <ul class="list-unstyled CTAs">
            <li><span class="glyphicon glyphicon-object-align-bottom"></span> <span class="label label-success">Position</span> <span class="label label-default"><?php if ($profileDetails) echo $profileDetails['level']; else echo 'Pending'; ?>
            </span></li>

            <li><span class="label label-success"><span class="glyphicon glyphicon-list"></span> Basic Information</span></li>

            <li><span class="glyphicon glyphicon-gift"></span> <?php if ($profileDetails) echo $profileDetails['birthday']; else echo 'NA'; ?></li>
            <li><span class="glyphicon glyphicon-road"></span> <?php if ($profileDetails) echo $profileDetails['address']; else echo 'NA'; ?></li>
        </ul>
      </nav>