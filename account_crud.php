<?php
    session_start();
    $remarks = $mysqli->query("SELECT * FROM remarks");
    $shapersAssigned = $mysqli->query("SELECT * FROM users");
    $shapersAssigned2 = $mysqli->query("SELECT * FROM users");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['accountSchedRecord'])){
            $_SESSION['accountAmend'] = $_POST['accountSchedRecord'];
        }
    
        if(isset($_POST['accountSchedRecordToDelete'])){
            $_SESSION['accountDelete'] = $_POST['accountSchedRecordToDelete'];
            
        }

        /** Amend Account Session ID SET */
        if(strlen($_SESSION['accountAmend']) != 0){
            $accountAmend = $_SESSION['accountAmend'];
            $accountAmendResult = $mysqli->query("SELECT * FROM account WHERE id  = '$accountAmend'");

            if ( $accountAmendResult->num_rows == 0 ){ 
                $_SESSION['message'] = "Schedule of Account doesn't exist!";
                header("location: error.php");

            }else{
                $accountAmend = $accountAmendResult->fetch_assoc();            
                
            }
        }

        /** Delete Shaper Talk Session ID SET */
        if(strlen($_SESSION['accountDelete']) != 0){  
            $accountDelete = $_SESSION['accountDelete'];
        }

    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if (isset($_POST['submitNewAccount'])) { 
            $account = $mysqli->escape_string($_POST['account']);
            $category = $mysqli->escape_string($_POST['category']);
            $shaperIds = json_decode($_POST['record_accounts'],true); 
            $head = json_decode($_POST['record_heads'],true);;
            $level = $_POST['level'];
            $remarks_val = $_POST['remarks'];
            $base = $_POST['base'];
            $rate = $_POST['rate'];
            $shapers_share = $_POST['shapers_share'];
            $lebrans_share = $_POST['lebrans_share'];

            /**Insert into account Table */
            $accountSQL = "INSERT INTO account (id, name, category, level, remarks, base, rate, shapers_share, lebrans_share)
            VALUES (null, '$account', '$category', '$level', '$remarks_val', '$base', '$rate', '$shapers_share', '$lebrans_share');";

            if($mysqli->query($accountSQL)){
                $_SESSION['message'] = '<span class="glyphicon glyphicon-ok-sign"></span> Schedule of Account Succesfully Added';
                /**GET INSERTED ACC ID**/
                $last_id = $mysqli->insert_id;
            }else{
                $_SESSION['message'] = 'Addition of new Schedule of Account Failed!';
            }

            /**Insert into shaper Map */
           foreach( $shaperIds as $shaperID) {
               $shapersQL = "INSERT INTO shaper_map (account_id, user_id)
                VALUES ($last_id, $shaperID);";

                if($mysqli->query($shapersQL)){
                    $_SESSION['message'] = 'New Shaper Successfully Added !';

                }else{
                    $_SESSION['message'] = 'Addition of new Shaper Failed!';
                }
           }

            /**Insert into user head Map */
           foreach($head as $shaperID) {
               $shapersQL = "INSERT INTO head_map (account_id, user_id)
                VALUES ($last_id, $shaperID);";

                if($mysqli->query($shapersQL)){
                    $_SESSION['message'] = 'New Shaper Successfully Added !';

                }else{
                    $_SESSION['message'] = 'Addition of new Shaper Failed!';
                }
           }

           // header("location: admin_sched_accounts.php");

        }else if (isset($accountAmend)){
            $account = $mysqli->escape_string($_POST['account']);
            $category = $mysqli->escape_string($_POST['category']);
            $shaperIds = json_decode($_POST['record_accounts'],true); 
            $head = json_decode($_POST['record_heads'],true);;
            $level = $_POST['level'];
            $remarks_val = $_POST['remarks'];
            $base = $_POST['base'];
            $rate = $_POST['rate'];
            $shapers_share = $_POST['shapers_share'];
            $lebrans_share = $_POST['lebrans_share'];

            $accountSQLUpdate = "UPDATE account SET name = '$account', category= '$category', level = '$level',
            remarks = '$remarks_val', base = '$base', rate='$rate', shapers_share='$shapers_share', lebrans_share='$lebrans_share' WHERE id = '$accountAmend'";

            $shaperSQLDelete = "DELETE FROM shaper_map where account_id='$accountAmend'";
            if($mysqli->query($shaperSQLDelete)){
            }else{
               echo 'ERROR';
            }

            /**Insert into shaper Map */
            foreach( $shaperIds as $shaperID) {
               $shapersQL = "INSERT INTO shaper_map (account_id, user_id)
                VALUES ($last_id, $shaperID);";

                if($mysqli->query($shapersQL)){
                    $_SESSION['message'] = 'New Shaper Successfully Added !';

                }else{
                    $_SESSION['message'] = 'Addition of new Shaper Failed!';
                }
            }

            $headSQLDelete = "DELETE FROM head_map where account_id='$accountAmend'";
             if($mysqli->query($shaperSQLDelete)){
            }else{
               echo 'ERROR';
            }
            
            /**Insert into shaper Map */
            foreach( $head as $shaperID) {
               $headSQL = "INSERT INTO head_map (account_id, user_id)
                VALUES ($last_id, $shaperID);";

                if($mysqli->query($headSQL)){
                    $_SESSION['message'] = 'New Shaper Successfully Added !';

                }else{
                    $_SESSION['message'] = 'Addition of new Shaper Failed!';
                }
            }

            if($mysqli->query($accountSQLUpdate)){
                $_SESSION['message'] = '<span class="glyphicon glyphicon-ok-sign"></span> Schedule of Account Succesfully Amended';
                header("location: admin_sched_accounts.php");
            }else{
               echo mysqli_error($mysqli);
            }

        }else if (strlen($_SESSION['accountDelete']) != 0){
            /** Delete Head Map*/
            $headSQLDelete = "DELETE FROM head_map WHERE account_id = '$accountDelete'";
            if($mysqli->query($headSQLDelete)){
            }else{
                echo mysqli_error($mysqli);
            }

            /** Delete Shaper Map*/
            $shaperSQLDelete = "DELETE FROM shaper_map WHERE account_id = '$accountDelete'";
            if($mysqli->query($shaperSQLDelete)){
            }else{
                echo mysqli_error($mysqli);
            }

            /**Delete Shaper Record */
            $accountDeleteSQLDelete = "DELETE FROM account WHERE id = '$accountDelete'";
            if($mysqli->query($accountDeleteSQLDelete)){
                $_SESSION['message'] = '<span class="glyphicon glyphicon-ok-sign"></span> Record Succesfully Deleted';
               header("location: admin_sched_accounts.php");
            }else{
                echo mysqli_error($mysqli);
            }


        }
        
    }


?>
