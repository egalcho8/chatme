<style>
    input[type=text], input[type=file],input[type=email],input[type=tel] { 
    width: 100%; 
    padding: 12px 20px; margin: 8px 0; 
    display: inline-block;
    border: 1px solid #ccc;
     box-sizing: border-box; 
    }

 /* Set a style for all buttons */ .demo { 
    background-color: #48d1cc;
     color: white; padding: 14px 20px;
     margin: 8px 0; border: none;
     cursor: pointer; width: 100%; 
    } .cancelbtn { 
    width: auto;
     padding: 10px 18px;

     background-color: #4682b4;
      } /* Center the image and position the close button */ 
     .imgcontainer { 

     text-align: center;
      margin: 24px 0 12px 0;
      position: relative; 
 } img.avatar { ;
  border-radius: 50%;
  } .container { 
    padding: 16px; 
  } span.psw {
   float: right; 
   padding-top: 16px;
    } .modal { /*
     display: none;
      position: fixed; 
     z-index: 1; 
     left: 0;
      top: 0;*/
      width: 100%; 
      height: 100%; 

     overflow: auto;
 background-color: rgb(0,0,0); 
      background-color: rgba(0,0,0,0.4);
      padding-top: 60px;
      
  }
    
      .modal-content { 
    background-color: #fefefe;
     margin: 5% auto 15% auto; 
     border: 1px solid #888;
      width: 400px; 
    } 
    /* The Close Button (x) */
     .close { 
        position: absolute;
         right: 25px; 
     top: 0; color: #000; 
     font-size: 35px; 
     font-weight: bold; 
    } .close:hover, .close:focus {
     color: red;
      cursor: pointer; 
    } /* Add Zoom Animation */ 
    .animate { 
    -webkit-animation: animatezoom 0.6s;
     animation: animatezoom 0.6s 
    } 
    @-webkit-keyframes animatezoom {
     from {
     -webkit-transform: scale(0)
    } to {
    -webkit-transform: scale(1)
  } 
} @keyframes animatezoom { 
    from {transform: scale(0)
    } to {transform: scale(1)
    } 
} 

@media screen and(max-width: 300px){
    span.psw { 
        display: block; 
        float: none; 
    } .cancelbtn {
     width: 100%;
      } 
    } 



</style>

<?php
require 'includes/init.php';
if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
    $user_data = $user_obj->find_user_by_id($_SESSION['user_id']);
    if($user_data ===  false){
        header('Location: logout.php');
        exit;
    }
  
    $all_users = $user_obj->all_users($_SESSION['user_id']);
}
else{
    header('Location: logout.php');
    exit;
}

$get_req_num = $frnd_obj->request_notification($_SESSION['user_id'], false);

$get_frnd_num = $frnd_obj->get_all_friends($_SESSION['user_id'], false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo  $user_data->username;?></title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<style type="text/css">
    .pmr img{
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }
</style>
<body style="background-color:powderblue;">
    
    <div class="profile_container">
        
        <div class="inner_profile">
            <div class="img">
<?php 
       include('dbconnect.php');
        $data   = $_SESSION['user_id'];
       $result = mysqli_query($conn, "SELECT * FROM pro WHERE user_id=$data ORDER BY id DESC LIMIT 1");
    
                if($result){
                    foreach($result as $row){
                        echo '<div class="user_box">
                                <div class="pmr"><img src="uploads/'.$row['image'].'"></div>
                                
                               
                            </div>';
                    }
                }
                else{
                    echo '<h4>There is no user!</h4>';
                }
                
  ?>
            </div>
            <h1><?php echo  $user_data->username;?></h1>
        </div>
        <nav>
            <ul>
                 <li><a href="home.php" rel="noopener noreferrer" class="active">Home</a></li>
                <li><a href="profile.php" rel="noopener noreferrer" class="active">all users</a></li>
                <li><a href="notifications.php" rel="noopener noreferrer">Requests<span class="badge <?php
                if($get_req_num > 0){
                    echo 'redBadge';
                }
                ?>"><?php echo $get_req_num;?></span></a></li>
                <li><a href="friends.php" rel="noopener noreferrer">Friends<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
                <li><a href="pro.php" rel="noopener noreferrer" class="active">change profile</a></li>
                 <li><a href="post.php" rel="noopener noreferrer" class="active">post</a></li>
                <li><a href="logout.php" rel="noopener noreferrer">Logout</a></li>
            </ul>
        </nav>
        <?php
include('dbconnect.php');
 
  $msg = "";

//$l= "SELECT *FROM name_of_table_one INNER JOIN name_of_table_two ON name_of_table_one.name_column_one = name_of_table_two.name_column_one"
  $sq = "SELECT user_two FROM `friends` WHERE (user_one = :my_id AND user_two = :frnd_id) OR (user_one = :frnd_id AND user_two = :my_id)";

$data   = $_SESSION['user_id'];
 
$result=$_SESSION['username'];
 
  if (isset($_POST['upload'])) {
  
    $image = $_FILES['image']['name'];
    
  $name= mysqli_real_escape_string($conn, $_POST['name']);
   
   
    $target = "uploads/".basename($image);

$sql = "INSERT INTO post (image,user_id,massage,name,user_two) VALUES ('$image','$data','$name','$result','$sq')";
   
    mysqli_query($conn, $sql);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
        
        // header('location: home.php');
    }else{
        $msg = "Failed to upload image";
    }
  }
  
?>
        <div class="all_users">
            <h3>All Users</h3>
            <div class="usersWrapper">
               <br><br>
<div id="content" >
  
        <div id="id01" class="modal"> 
  <form method="POST" action="" enctype="multipart/form-data" class="modal-content animate" name="my">
    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] :'' ?>">
        <input type="hidden" name="folder_id" value="<?php echo isset($_GET['fid']) ? $_GET['fid'] :'' ?>">
        
        
    <div class="container">
    <input type="hidden" name="size" value="1000000">
    
    
        <label>file</label>
      <input type="file" name="image" required>
   
      <input type="text" name="name" required height="200">
    
        
        <button type="submit" name="upload">POST</button>
    
    <div class="container" style="background-color:#f1f1f1">
         <button type="button" onclick="document.getElementById ('id01').style. display='none'" class="cancelbtn"> Cancel</button> 
         
         </span> 
        </div>
  </form>
  </div>
            </div>
        </div>
        
    </div>
    


</body>
</html>
<?php/*

  if (isset($_SESSION['userid'])) {
     $session_id = $_SESSION['userid'];
  }


 $sql = "SELECT *,

(SELECT username FROM users WHERE userid=from_id) AS from_username,
(SELECT username FROM users WHERE userid=to_id) AS to_username,
(SELECT username FROM users WHERE userid=?) AS my_username,
(SELECT from_id, COUNT(*) unread FROM pm WHERE to_id=? AND read='0' GROUP BY from_id)


 FROM pm WHERE from_id = ? or to_id=?   ORDER BY id DESC";

 if ($stmt->prepare($sql)) {
    $stmt->bind_param('iiii', $session_id, $session_id,$session_id,$session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
       echo $row['from_username'] . " -> " . $row['to_username'] . "<br>";
       echo 'User ' . $row['from_id'] . ' - ' . $row['unread'];
    }
   }*/
 ?>