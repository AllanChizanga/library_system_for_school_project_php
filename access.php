<?php
//php class for login and logout different users
//require
require_once 'database.php';
//session
session_start();
class Access{
   
    //values
    public $email;
    public $password;
    public $user;
    public $state; //whether or not user is logged in 
    //methods
    //MEMBER_LOGIN
    //allows members to login and see how many books they borrowed
    //when the books are wanted
    //information about subscriptions
    //platform to pay online for subscriptions or penalties
    //news and notices from the library
    function login($email,$password,$user){
      //inputs
       $this->email = $email;
       $this->password = $password;
       $this->user = $user;

      //select from database
       $conn = new Connection();
       if($user == 'librarian'){
        $conn->query = "Select *  FROM librarian Where email = '{$this->email}' AND member_password =  '{$this->password}'";
       }
       else if($user == 'management'){
        $conn->query = "Select *  FROM management Where email = '{$this->email}' AND member_password =  '{$this->password}'";
       }
       else if($user == 'member'){
        $conn->query = "Select *  FROM member Where email = '{$this->email}' AND member_password =  '{$this->password}'";

       }
       else{
        echo "Please select user";
       }

       $conn->prepare();
       $result = $conn->select(); //return a single matching record
      if(!empty($result)){
        $this->state ='logged_in';
      $_SESSION['state'] = $this->state; //new session
  //header('location:../backend/dashboard.php'); //go to dashboard
     echo true; //use javascript to open new page
}
else{
 // header('location:../index.php');
  echo false;
}
  


    }//endof member_login
    //LIBRARIAN_LOGIN_METHOD
    /* gives access to the library page
    where the librarian manages books and payments*/
    function librarian_login(){


    }//endof librarian_login
    //MANAGEMENT_LOGIN METHOD
    //to give access to the manager 
    function management_login(){


    }//endof management_login
//LOGOUT ALL
    function logout(){
        unset($_SESSION['state']);
        header('location:../index.php');//return to login page
    }//endof function logout
} //endof class
//onjects
if(isset($_POST['login'])){
$access = new Access();
$access->login($_POST['email'],$_POST['password'],$_POST['user']);
}
else if(isset($_POST['logout'])){
    $access = new Access();
    $access->logout($_POST['email'],$_POST['password'],$_POST['user']);
}
else{

}
?>
