<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
$address = $mysqli->escape_string($_POST['address']);
$birthday = $_POST['birthday'];
$accountName = $mysqli->escape_string($_POST['accountName']);
$accountNumber = $mysqli->escape_string($_POST['accountNumber']);
if(isset($_FILES['profilePhoto'])){
    
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



// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");
    
}
else { // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO users (first_name, last_name, email, password, hash, type) " 
            . "VALUES ('$first_name','$last_name','$email','$password', '$hash', 'common')";

    
    // Add user to the database
    if ( $mysqli->query($sql) ){

        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
        $_SESSION['logged_in'] = true; // So we know the user has logged in
        $_SESSION['message'] =
                
                 "Confirmation link has been sent to $email, please verify
                 your account by clicking on the link in the message!";

        // Send registration confirmation link (verify.php)
        $to      = $email;
        $subject = 'Account Verification ( Lebran )';
        $message_body = '
        Hello '.$first_name.',

        Thank you for signing up!

        Please click this link to activate your account:

        http://localhost/lebran/verify.php?email='.$email.'&hash='.$hash;  

        mail( $to, $subject, $message_body );

        $newUserId = $mysqli->insert_id;
        $profileSQL = "INSERT INTO PROFILE (userID, head_shot, address, birthday, account_number, account_name, level)
        VALUES ('$newUserId','$new_file_name','$address','$birthday','$accountNumber','$accountName', null)";

        $mysqli->query($profileSQL);
        //Add Confirmation Page
        header("location: index.php"); 

    }

    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
    }

}