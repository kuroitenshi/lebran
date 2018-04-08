<?php 
	
	 session_start();
	 require 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    	if(isset($_POST['update_profile'])){

    		$userId = $_SESSION['userid'];
    		$first_name = $_POST['firstname'];
		    $last_name = $_POST['lastname'];
		    $email = $_POST['email'];
		    $password = $_POST['password'];
		    $hash = $mysqli->escape_string( md5( rand(0,1000) ) );
		    $address = $_POST['address'];
		    $accountNumber = $_POST['accountNumber'];
		    $accountName = $_POST['accountName'];
		    $birthday = $_POST['birthday'];
		    $new_file_name  = null;
		    $type = $_SESSION['type'];

		    if($_FILES['profilePhoto']['size'] != 0){
    
			    $errors= array();  
			    $file_size =$_FILES['profilePhoto']['size'];
			    $file_tmp =$_FILES['profilePhoto']['tmp_name'];
			    $file_type=$_FILES['profilePhoto']['type'];
			    $file_name_explode = explode('.',$_FILES['profilePhoto']['name']);
			    $file_ext = strtolower(end($file_name_explode));
			    $new_file_name = $first_name.' '.$last_name.".$file_ext";
			    
			    $expensions= array("jpeg","jpg","png");
			    
			    if(in_array($file_ext,$expensions)=== false){
			       $errors[]="File Extension not allowed, please choose a JPEG or PNG file.";
			    }
			    
			    if($file_size > 2097152){
			       $errors[]='Please only upload photos with file size up to 2 MB';
			    }
			    
			    if(empty($errors)==true){
			       move_uploaded_file($file_tmp,"profileImages/".$new_file_name);
			       echo "Success";
			    }else{
			       print_r($errors);
			    }
			 }

			// active is 0 by DEFAULT (no need to include it here)
    		$sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', 
    		password = '$password', hash = '$hash' WHERE id = '$userId'";

    		echo $mysqli->query($sql);

            if($mysqli->query($sql)){

            }else{
            	echo "ERROR";
            }

            $profileSQL = null;
            if($new_file_name != null){

            $profileSQL = "UPDATE PROFILE SET head_shot='$new_file_name', address='$address', birthday='$birthday', account_number='$accountNumber', account_name='accountName' WHERE userID='$userId'";
            	echo 'not null';
        	}
        	else{
    		 $profileSQL = "UPDATE PROFILE SET address='$address', birthday='$birthday', account_number='$accountNumber', account_name='accountName' WHERE userID='$userId'";

    		 echo 'null';
        	}

        	if($mysqli->query($profileSQL)){

        		if($type == 'admin')
        			header('location: profileadmin.php');
        		else
        			header('location: profile.php');
            }else{
            	echo "ERROR";
            }

    	}
    }
?>
