<?php 

    $currentUserId = $_SESSION['userid']; 
    $profileDetailsResult = $mysqli->query("SELECT * FROM PROFILE WHERE USERID = '$currentUserId'");
    $profileDetails = $profileDetailsResult->fetch_assoc();


?>