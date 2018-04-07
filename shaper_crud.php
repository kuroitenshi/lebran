<?php 
    session_start();
    $currentUserId = $_SESSION['userid']; 
    $remarks = $mysqli->query("SELECT * FROM remarks");
    $possibleCoShapers = $mysqli->query("SELECT * FROM USERS WHERE id  != '$currentUserId'");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['shaperRecord']))
            $_SESSION['shaperIDToAmend'] = $_POST['shaperRecord'];

         if(isset($_POST['shaperRecordToDelete']))
             $_SESSION['shaperIDToDelete'] = $_POST['shaperRecordToDelete'];
    }

    if(strlen($_SESSION['shaperIDToAmend']) != 0){
        $shaperIDToAmend = $_SESSION['shaperIDToAmend'];
        $shaperToAmendResult = $mysqli->query("SELECT * FROM SHAPER_RECORD WHERE id  = '$shaperIDToAmend'");
        
        if ( $shaperToAmendResult->num_rows == 0 ){ 
            $_SESSION['message'] = "Shaper Record doesn't exist!";
            //header("location: error.php");
        }else{
            $shaperRecordToAmend = $shaperToAmendResult->fetch_assoc();
            $remarksIDSelected = $shaperRecordToAmend['remarks'];                         
            $shaperRecordToAmendRemarkQuery = $mysqli->query("SELECT * FROM remarks WHERE id  = '$remarksIDSelected'");
            $shaperRecordToAmendRemark = $shaperRecordToAmendRemarkQuery->fetch_assoc();
            $shaperRecoredToAmendCoShapersQuery = $mysqli->query("SELECT DISTINCT COSHAPER_MAP.COSHAPERUSERID AS userid, USERS.FIRST_NAME as first_name, USERS.LAST_NAME as last_name FROM COSHAPER_MAP
                INNER JOIN USERS ON USERS.ID = COSHAPER_MAP.COSHAPERUSERID WHERE COSHAPER_MAP.SHAPERID = '$shaperIDToAmend' ");
            $shaperRecordToAmendCoShaper = $shaperRecoredToAmendCoShapersQuery->fetch_assoc();
        }
    }

    if(strlen($_SESSION['shaperIDToDelete']) != 0){
        $shaperIDToDelete = $_SESSION['shaperIDToDelete'];
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if (isset($_POST['submitNewShaperRecord'])) { //Add new Shaper Record
            $record_date = $_POST['record_date'];
            $record_account = $mysqli->escape_string($_POST['record_account']);
            $record_remark = $mysqli->escape_string($_POST['record_remark']);
            $record_base = $_POST['record_base'];
            $record_rate = $_POST['record_rate'];
            $record_fee = $_POST['record_fee'];            
            $record_coshapers = json_decode($_POST['record_coshapers'],true); 

           
           /**Insert into Shaper Table */
          $shaperSQL = "INSERT INTO SHAPER_RECORD (userId, date, account, remarks, base, rate, fee)
            VALUES ('$currentUserId', '$record_date', '$record_account', '$record_remark', '$record_base', '$record_rate', '$record_fee');";

            if($mysqli->query($shaperSQL)){
                $newShaperId = $mysqli->insert_id;
            }else{
                $_SESSION['message'] = 'Addition of new Shaper Failed!';
                header("location: error.php");
            }

           /**Insert into CoShaper Map */
           foreach( $record_coshapers as $coShaperID) {
               $coShaperSQL = "INSERT INTO COSHAPER_MAP (userId, coShaperUserID, shaperID)
                VALUES ($currentUserId, $coShaperID, $newShaperId);";

                if($mysqli->query($coShaperSQL)){
                    $_SESSION['message'] = 'New Shaper Successfully Added !';

                }else{
                    $_SESSION['message'] = 'Addition of new Shaper Failed!';
                    echo mysqli_error($mysqli);
                    header("location: error.php");
                }
           }

           header("location:profileadmin.php");
                
        }else if(isset($_POST['updateShaperRecord'])){
            $record_date = $_POST['record_date'];
            $record_account = $mysqli->escape_string($_POST['record_account']);
            $record_remark = $mysqli->escape_string($_POST['record_remark']);
            $record_base = $_POST['record_base'];
            $record_rate = $_POST['record_rate'];
            $record_fee = $_POST['record_fee'];            
            $record_coshapers = json_decode($_POST['record_coshapers'],true); 

            $shaperSQLUpdate = "UPDATE SHAPER_RECORD SET date = '$record_date', account= '$record_account', remarks = '$record_remark',
            base = '$record_base', rate = '$record_rate', fee = '$record_fee' WHERE id = '$shaperIDToAmend'";

            if($mysqli->query($shaperSQLUpdate)){

            }else{
               echo mysqli_error($mysqli);
            }

            /**Delete CoShaper Mappings */
            $coShaperSQLDelete = "DELETE FROM COSHAPER_MAP WHERE SHAPERID = '$shaperIDToAmend'";
            $mysqli->query($coShaperSQLDelete);

            /**Insert into CoShaper Map */
           foreach( $record_coshapers as $coShaperIDUpdate) {
            $coShaperSQL = "INSERT INTO COSHAPER_MAP (userId, coShaperUserID, shaperID)
             VALUES ($currentUserId, $coShaperIDUpdate, $shaperIDToAmend);";

             if($mysqli->query($coShaperSQL)){
                 $_SESSION['message'] = 'Shaper Successfully Amended!';
             }else{
                echo mysqli_error($mysqli);
             }     
            }

            header("location:profileadmin.php");

            
        }else if(strlen($_SESSION['shaperIDToDelete']) != 0) {
            /**Delete CoShaper Mappings */
            $coShaperSQLDelete = "DELETE FROM COSHAPER_MAP WHERE shaperID = '$shaperIDToDelete'";
            if($mysqli->query($coShaperSQLDelete)){

            }else{
                echo mysqli_error($mysqli);
            }

            /**Delete Shaper Record */
            $shaperSQLDelete = "DELETE FROM SHAPER_RECORD WHERE id = '$shaperIDToDelete'";
            if($mysqli->query($shaperSQLDelete)){
                 $_SESSION['message'] = 'Shaper Successfully Deleted!';
                 header("location: profileadmin.php");

            }else{
                echo mysqli_error($mysqli);
            }


        }
    
    
    }

?>