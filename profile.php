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
    } .modal { 
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
       $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$data ");
    
                if($result){
                    foreach($result as $row){
                        echo '<div class="user_box">
                                <div class="pmr"><img src="uploads/'.$row['user_image'].'"></div>
                                
                               
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
        <style type="text/css">
            .sidenav { float: right;margin-left: 60%;height: 100%; width: 0; position: fixed; z-index: 1; top: 0; left: 0;  background-color: #111; overflow-x: hidden; transition: 0.5s; padding-top: 60px; } .sidenav a { padding: 8px 8px 8px 32px; text-decoration: none; font-size: 25px; color: #818181; display: block; transition: 0.3s } .sidenav a:hover, .offcanvas a:focus{ color: #f1f1f1; } .sidenav .closebtn { position: absolute; top: 0; right: 25px; font-size: 36px; margin-left: 50px; } @media screen and (max-height: 450px){ .sidenav {padding-top: 15px;} .sidenav a {font-size: 18px;} } 
        </style>
        <nav>
            <ul>
                <li><a href="home.php" rel="noopener noreferrer" class="active">Home</a></li>
                <li><a href="profile.php" rel="noopener noreferrer" class="active">all users</a></li>
                <li><a href="pro.php" rel="noopener noreferrer" class="active">change profile</a></li>
                 <div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <li><a href="notifications.php" rel="noopener noreferrer">Requests<span class="badge <?php
                if($get_req_num > 0){
                    echo 'redBadge';
                }
                ?>"><?php echo $get_req_num;?></span></a></li>
                <li><a href="friends.php" rel="noopener noreferrer">Friends<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
                
                <li><a href="logout.php" rel="noopener noreferrer">Logout</a></li>
                </div> 
                <p></p> 
                <span style="font-size:30px;cursor: pointer; color: white;"onclick="openNav()">☰</span>
               
            </ul>
        </nav>
         <script> /* Set the width of the side navigation to 250px */ function openNav() { document.getElementById("mySidenav") .style.width="250px"; } function closeNav() { document.getElementById("mySidenav") .style.width = "0"; } </script>
        <div class="all_users">
            <h3>All Users</h3>
            <div class="usersWrapper">
                <?php
                include('dbconnect.php');
        $data   = $_SESSION['user_id'];
       
       $result = mysqli_query($conn, "SELECT * FROM users ");
    
                if($result){
                    foreach($result as $row){
                        echo '<div class="user_box">
                                
                                <div class="user_info"><span>'.$row['username'].'</span>
                                <div class="pm"><img src="uploads/'.$row['user_image'].'"></div>
                                <span><a href="user_profile.php?id='.$row['id'].'" class="see_profileBtn">See profile</a></div>
                            </div>';
                    }
                }
                else{
                    echo '<h4>There is no user!</h4>';
                }
                ?>
            </div>
        </div>
        
    </div>
    <style type="text/css">
        .pm img{
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    </style>

<br><br>
<div id="content" >
  
        <div id="id01" class="modal"> 
  <form method="POST" action="change.php" enctype="multipart/form-data" class="modal-content animate" name="my">
    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] :'' ?>">
        <input type="hidden" name="folder_id" value="<?php echo isset($_GET['fid']) ? $_GET['fid'] :'' ?>">
        
        
    <div class="container">
    <input type="hidden" name="size" value="1000000">
    
    
        <label>file</label>
      <input type="file" name="image" required>
   
 
    
        
        <button type="submit" name="upload">POST</button>
    
    <div class="container" style="background-color:#f1f1f1">
         <button type="button" onclick="document.getElementById ('id01').style. display='none'" class="cancelbtn"> Cancel</button> 
         
         </span> 
        </div>
  </form>
  </div>
</body>
</html>