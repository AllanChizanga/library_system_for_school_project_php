<?php
session_start();
require_once 'database.php';
class Notification{
    //properties
    public $id;
    public $the_message;
    public $is_read;
    //methods
    public function view(){
        $conn = new Connection();
        $conn->query = "SELECT * from notifications WHERE is_read = false";
        $conn->prepare();
        $notifications = $conn->selectAll();
        if(!empty($notifications)){
           foreach($notifications as $notice){
               echo "<hr><a class='text-light notice'href='../php/notifications.php?id={$notice['id']}'>{$notice['the_message']}</a>
               <input type='hidden'value='{$notice['id']}'id='hidden_notice_input'>";
               
           }//endof loop
        
   
        }else{
           echo "<p class='text-warning'> There are no books in the database yet </p>";
           
           
        }
       }//end of view method 

       public function update($notice_id){
        //update notice is_read to true using id
        $this->id = $notice_id;
        $conn = new Connection();
        $conn->query = "UPDATE notifications SET
        is_read = true WHERE id = {$this->id}";
        $conn->prepare();
        $success = $conn->insert();
        if($success){
            echo true;
        }
        else{
            echo false;
        }
       }//endof update method

}//endof class
if(isset($_POST['view_notifications'])){
$notification = new Notification();
$notification->view();
}//endif

else if(isset($_POST['id'])){
    $notification = new Notification();
    $notification->update($_POST['notice_id']);
    }//endif