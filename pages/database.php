<?php

// Connect to database
$conn = new mysqli("localhost", "root", "", "doneupdates");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$userIp = $_SERVER['REMOTE_ADDR'];
if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'ARTIST')) {
    $user_id=$userIp;
    }else{
      $user_id=$_SESSION['user_id'];
      if(!$_SESSION['email_verified'] !== 1){
          // Destroy session
      session_destroy(); 
        echo '<div class="error">Your Account is not verified yet please initiate a login then check your email to verify, please wait</div>';
    
        echo '<script type="text/javascript">
                setTimeout(function() {
                    window.location.href = "signin.php";
                }, 10000); // 10 seconds delay (10000 milliseconds)
              </script>';
        exit;
      }
    }
?>