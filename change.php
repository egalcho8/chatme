<?php

 
  $msg = "";


$data   = $_SESSION['user_id'];

   include('dbconnect.php');
  if (isset($_POST['upload'])) {
  
    $image = $_FILES['image']['name'];
    

   
   
    $target = "uploads/".basename($image);

$sql = "UPDATE users SET user_image as '$image' WHERE id='$data' )";
   
    mysqli_query($conn, $sql);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
        
         //header('location: private.php');
    }else{
        $msg = "Failed to upload image";
    }
  }
  
?>