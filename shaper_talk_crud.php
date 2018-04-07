<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['shaperTalkRecord'])){
            $_SESSION['shaperTalkToAmend'] = $_POST['shaperTalkRecord'];
        }
    
        if(isset($_POST['shaperTalkRecordToDelete'])){
            $_SESSION['shaperTalkToDelete'] = $_POST['shaperTalkRecordToDelete'];
            
        }

        /** Amend Shaper Talk Session ID SET */
        if(strlen($_SESSION['shaperTalkToAmend']) != 0){
            $shaperTalkToAmend = $_SESSION['shaperTalkToAmend'];
            $shaperTalkToAmendResult = $mysqli->query("SELECT * FROM SHAPER_TALKS WHERE id  = '$shaperTalkToAmend'");

            if ( $shaperTalkToAmendResult->num_rows == 0 ){ 
                $_SESSION['message'] = "Shaper Talk Record doesn't exist!";
                header("location: error.php");

            }else{
                $shaperTalkRecordToAmend = $shaperTalkToAmendResult->fetch_assoc();            
                
            }
        }

        /** Delete Shaper Talk Session ID SET */
        if(strlen($_SESSION['shaperTalkToDelete']) != 0){  
            $shaperTalkToDelete = $_SESSION['shaperTalkToDelete'];
        }

    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if (isset($_POST['submitNewShaperTalk'])) { 
            $talk_account = $mysqli->escape_string($_POST['talk_account']);
            $talk_topic = $mysqli->escape_string($_POST['talk_topic']);
            $talk_speaker = $mysqli->escape_string($_POST['talk_speaker']);
            $talk_fee = $_POST['talk_fee'];
        
            /**Insert into Shaper Talks Table */
            $shaperTalkSQL = "INSERT INTO SHAPER_TALKS (account, topic, speaker, fee)
            VALUES ('$talk_account', '$talk_topic', '$talk_speaker', '$talk_fee');";

            if($mysqli->query($shaperTalkSQL)){
                $_SESSION['message'] = '<span class="glyphicon glyphicon-ok-sign"></span> Schedule Succesfully Added';
                header("location: admin_shaper_talks.php");
            }else{
                $_SESSION['message'] = 'Addition of new Shaper Talk Failed!';
                header("location: error.php");
            }
        }else if (isset($_POST['updateShaperTalk'])){
            $talk_account = $mysqli->escape_string($_POST['talk_account']);
            $talk_topic = $mysqli->escape_string($_POST['talk_topic']);
            $talk_speaker = $mysqli->escape_string($_POST['talk_speaker']);
            $talk_fee = $_POST['talk_fee'];

            $shaperTalkSQLUpdate = "UPDATE SHAPER_TALKS SET account = '$talk_account', topic= '$talk_topic', speaker = '$talk_speaker',
            fee = '$talk_fee' WHERE id = '$shaperTalkToAmend'";

            if($mysqli->query($shaperTalkSQLUpdate)){
                $_SESSION['message'] = '<span class="glyphicon glyphicon-ok-sign"></span> Schedule Succesfully Amended';
                header("location: admin_shaper_talks.php");
            }else{
               echo mysqli_error($mysqli);
            }

        }else if (strlen($_SESSION['shaperTalkToDelete']) != 0){
            /**Delete Shaper Record */
            echo 'daan here ' .$shaperTalkToDelete;
            $shaperTalkSQLDelete = "DELETE FROM SHAPER_TALKS WHERE id = '$shaperTalkToDelete'";
            if($mysqli->query($shaperTalkSQLDelete)){
                $_SESSION['message'] = '<span class="glyphicon glyphicon-ok-sign"></span> Schedule Succesfully Deleted';
               header("location: admin_shaper_talks.php");
            }else{
                echo mysqli_error($mysqli);
            }


        }
        
    }


?>
