<?php
require 'includes/init.php';

function redirect_to_profile(){
    header('Location: profile.php');
    exit;
}

if(isset($_GET['action']) && isset($_GET['id'])){
    
    if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
       
        if($_GET['id'] == $_SESSION['user_id']){
            redirect_to_profile();
        }
      
        else{
         
            $user_id = $_GET['id'];
            $my_id = $_SESSION['user_id'];

            
            if($_GET['action'] == 'send_req'){
               
                if($frnd_obj->is_request_already_sent($my_id, $user_id)){
                    redirect_to_profile();
                }
               
             
                elseif($frnd_obj->is_already_friends($my_id, $user_id)){
                    redirect_to_profile();
                }
              
                else{
                    $frnd_obj->make_pending_friends($my_id, $user_id);
                }
            }elseif($_GET['action'] == 'send_massage'){
               
                //if($frnd_obj->is_request_already_sent($my_id, $user_id)){
                   // redirect_to_masage();
                //}
               
             
                if($frnd_obj->is_already_friends($my_id, $user_id)){
                    //redirect_to_profile();
                }
              
                else{
                    $frnd_obj->make_pending_friends($my_id, $user_id);
                }
            }
          
          
            else if($_GET['action'] == 'cancel_req' || $_GET['action'] == 'ignore_req'){
                $frnd_obj->cancel_or_ignore_friend_request($my_id, $user_id);
            }
            
            elseif($_GET['action'] == 'accept_req'){

                if($frnd_obj->is_already_friends($my_id, $user_id)){
                    redirect_to_profile();
                }
                else{
                    $frnd_obj->make_friends($my_id, $user_id);
                }
            }
         
            elseif($_GET['action'] == 'unfriend_req'){
                $frnd_obj->delete_friends($my_id, $user_id);
            }
            else{
                redirect_to_profile();
            }
        }
    }
    else{
        header('Location: logout.php');
        exit;
    }
}
else{
    redirect_to_profile();
}                    