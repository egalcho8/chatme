<?php
require 'includes/init.php';
if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
    if(isset($_GET['id'])){
        $user_data = $user_obj->find_user_by_id($_GET['id']);
        $_SESSION['id']=$user_data;
        if($user_data ===  false){
            header('Location: profile.php');
            exit;
        }
        else{
            if($user_data->id == $_SESSION['user_id']){
                header('Location: profile.php');
                exit;
            }
        }
    }
}
else{
    header('Location: logout.php');
    exit;
}

$is_already_friends = $frnd_obj->is_already_friends($_SESSION['user_id'], $user_data->id);

$check_req_sender = $frnd_obj->am_i_the_req_sender($_SESSION['user_id'], $user_data->id);

$check_req_receiver = $frnd_obj->am_i_the_req_receiver($_SESSION['user_id'], $user_data->id);

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
<body style="background-color:powderblue;">>
    <div class="profile_container">
        
        <div class="inner_profile">
            <div class="img">
            <!--  <img src="profile_images/<?php echo $user_data->user_image; ?>" alt="Profile image">-->
            </div>
            <h1><?php echo  $user_data->username;?></h1>
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
            <div class="actions">
                <?php
                if($is_already_friends){
                    echo '<a href="functions.php?action=unfriend_req&id='.$user_data->id.'" class="req_actionBtn unfriend">Unfriend</a>';
                     echo '<a href="massage.php?action=send_massage&id='.$user_data->id.'" class="req_actionBtn sendRequest">Send massage</a>';
                     $id=isset($_GET['user_id']);
                }
                elseif($check_req_sender){
                    echo '<a href="functions.php?action=cancel_req&id='.$user_data->id.'" class="req_actionBtn cancleRequest">Cancel Request</a>';
                }
                elseif($check_req_receiver){
                    echo '<a href="functions.php?action=ignore_req&id='.$user_data->id.'" class="req_actionBtn ignoreRequest">Ignore</a>&nbsp;
                    <a href="functions.php?action=accept_req&id='.$user_data->id.'" class="req_actionBtn acceptRequest">Accept</a>';
                }
                
                else{
                    echo '<a href="functions.php?action=send_req&id='.$user_data->id.'" class="req_actionBtn sendRequest">Send Request</a>';
                }
                 //echo '<a href="massage.php?action=send_massage&id='.$user_data->id.'" class="req_actionBtn ignoreRequest">Ignore</a>&nbsp;
                   // <a href="functions.php?action=accept_req&id='.$user_data->id.'" class="req_actionBtn acceptRequest">Accept</a>';
                ?>
        
            </div>
        </div>
     
        
    </div>
</body>
</html>