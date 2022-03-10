<?php
require 'includes/init.php';
//require 'masage.php';
if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
    $user_data = $user_obj->find_user_by_id($_SESSION['user_id']);
    if($user_data ===  false){
        header('Location: logout.php');
        exit;
    }
}
else{
    header('Location: logout.php');
    exit;
}

$get_req_num = $frnd_obj->request_notification($_SESSION['user_id'], false);

$get_frnd_num = $frnd_obj->get_all_friends($_SESSION['user_id'], false);

$get_all_friends = $frnd_obj->get_all_friends($_SESSION['user_id'], true);

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
        <style type="text/css">
            .active input{
                height: 50px;
                width: 80%;
            }
        </style>
        <div class="all_users">
            
            <center><p>make post</p><a href="post.php"  rel="noopener noreferrer" class="active"><input type="text" name="" placeholder="post samething here..."></a></center>
            <h3> friends</h3>
            <div class="usersWrapper">
                <?php

       include('dbconnect.php');
        $data   = $_SESSION['user_id'];
      
    $result= mysqli_query($conn ,"SELECT *FROM  pro INNER JOIN friends ON   pro.user_id=friends.user_two ");
             
               if($result){
                    foreach($result as $row){
                        echo '<div class="user_box"><fieldset>
                                <div class="user_img"><img src="uploads/'.$row['image'].'" alt="Profile image"></div>
                                <div class="user_info"><span>'.$row['name'].'</div>
                                <span><a href="user_profile.php?id='.$row['id'].'" class="see_profileBtn">See profile</a></span>
                                <span><a href="masage.php?id='.$row['id'].'" class="see_profileBtn">send massege</a></span>
                                </fieldset>
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
</body>
</html>