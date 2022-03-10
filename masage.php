
<?php
include('dbconnect.php');
require 'includes/init.php';
if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
    if(isset($_GET['id'])){
        $user_data = $user_obj->find_user_by_id($_GET['id']);
        //$_SESSION['id']=$user_data;
        if($user_data ===  false){
            header('Location: profile.php');
            exit;
        }
        else{
            if($user_data->id == $_SESSION['user_id']){
                header('Location: masage.php');
                exit;
            }
        }
    }
}
else{
    header('Location: logout.php');
    exit;
}

//$is_already_friends = $frnd_obj->is_already_friends($_SESSION['user_id'], $user_data->id);

//$check_req_sender = $frnd_obj->am_i_the_req_sender($_SESSION['user_id'], $user_data->id);

//$check_req_receiver = $frnd_obj->am_i_the_req_receiver($_SESSION['user_id'], $user_data->id);

//$get_req_num = $frnd_obj->request_notification($_SESSION['user_id'], false);

//$get_frnd_num = $frnd_obj->get_all_friends($_SESSION['user_id'], false);


                         $userid=$_SESSION['user_id'];
                            // $id=$_GET['id'];
                          if(isset($_POST['upload'])){
            
                        $massage=mysqli_real_escape_string($conn,$_POST['massage']);
                        $sql="INSERT INTO msg (user_one,user_two,massage) VALUES('$userid',' $user_data','$massage')";
                        mysqli_query($conn,$sql);
                        //header("Location, masage.php");
           }   
           // echo '<a href="functions.php?action=unfriend_req&id='.$user_data->id.'" class="req_actionBtn unfriend">Unfriend</a>';                     


       
        $data   = $_SESSION['user_id'];
      
    $result= mysqli_query($conn ,"SELECT *FROM  pro INNER JOIN friends ON   pro.user_id=friends.user_two ");
             
               if($result){
                    foreach($result as $row){
                        echo '<div class="user_box"><fieldset>
                                <div class="user_img"><img src="uploads/'.$row['image'].'" alt="Profile image"></div>
                                <div class="user_info"><span>'.$row['name'].'</div>
                                
                                <span><a href="masage.php?id='.$user_data.'" class="see_profileBtn">send massege</a></span>
                                </fieldset>
                            </div>';
                            
                           
               

          
                   
                         
                      
             }
                }
                else{
                    echo '<h4>There is no user!</h4>';
                }   
                 

             
                
                ?>

            
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>massage</title>
<link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<style type="text/css">
    textarea{
        height: 70px;
        width: 70%;
    }.massage{
        background-color: lightsteelblue;
        width: 150px;
        border-radius: 10px ;
         margin-left: 60%;
    }.massageone{
        background-color: powderblue;
        width: 150px;
        border-radius: 10px ;
        margin-left: 60%;
    }fieldset{
        max-height: 500px;
    }
</style>
<body style="background-color:powderblue;">
  <div class="main_container login_signup_container">
    <h1>send massage</h1>
<?php 
       include('dbconnect.php');
        $data   = $_SESSION['user_id'];
          //$to=($conn,"SELECT user_id FROM friends");
       $result = mysqli_query($conn, "SELECT * FROM msg WHERE user_one=$data ORDER by id ASC ");
    
                if($result){
                    foreach($result as $row){
                        echo '<fieldset><div class="user_box">
                                
                                <div class="massage">'.$row['massage'].'</div>
                                </div><br></fieldset>';
                                 




                                 }



                             }    
                             $result = mysqli_query($conn, "SELECT * FROM msg WHERE user_two=$data ORDER by id ASC ");
    
                       if($result){
                         foreach($result as $row){
                        echo '<fieldset><div class="user_box">
                                
                                <div class="massage">'.$row['massage'].'</div>
                                </div><br></fieldset>';
                                 




                                 }



                             }           
      
  ?>

    <hr>
    <form action="masage.php" method="POST">
      
      <textarea  name="massage"></textarea>
      <input type="submit" value="send" name="upload">
     
      <div>  
     
    </div>
    </form>
    
    
  </div>

</body>
</html>