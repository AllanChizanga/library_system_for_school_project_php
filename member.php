<?php
session_start();
require_once 'database.php';

class Member{
    //PROPERTIES
public $member_id;
public $firstname;
public $lastname;
public $gender;
public $profile_image;
public $phone;
public $address;
public $national_id;
public $password;
public $email;
public $date_of_registration;
/*************************************************************
******************************************************************** */
//METHODS
public function add(
    $firstname,
    $lastname,
    $gender,
    $profile_image,
    $phone,
    $address,
    $national_id,
    $password,
    $email
)//parameters

{ 
    //variables
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->gender = $gender;
    $this->profile_image = $profile_image;
    $this->phone = $phone;
    $this->address = $address;
    $this->national_id = $national_id;
    $this->password= $password;
    $this->email = $email;
    //upload profile_image to server with user_id as image title
    $bookpathway = '../backend/members/'.$this->profile_image['name'];
    move_uploaded_file($this->profile_image['tmp_name'],$bookpathway);
    //if successful save the member to database
    $conn =  new Connection();
    $conn->query = "INSERT INTO 
    member(firstname,
    lastname,
    gender,
    profile_image,
    phone,
    member_address,
    national_id,
    member_password,
    email)
    VALUES(
     '{$this->firstname}',
     '{$this->lastname}',
     '{$this->gender}',
    '{$this->profile_image['name']}',
     '{$this->phone}',
     '{$this->address}',
     '{$this->national_id}',
     '{$this->password}',
     '{$this->email}')";//end of query
    $conn->prepare(); //prepared 
    $success = $conn->insert();//exec
    $conn->close();//close connection
    if($success){
      //add to notification database

      $conn = new connection();//open new connection
      $conn->query = "INSERT INTO notifications(the_message,is_read) VALUES('New Member has been create {$this->firstname} {$this->lastname}',false)";
      $conn->prepare();
      $conn->insert();
      $conn->close();
      //give feedback to user 
     echo "<p class='text-light'>Book successfully added</p>";
    }//execute successfull
    else{
        echo "<p class='text-danger'>Could not add new member</p>";
    } //return feedback


} //end_of_add_function


function update(){

}//endof_update_function

function view(){

}//endof_view_function

function delete(){

}//endof_delete_function


}//END_MEMBER_CLASS
/*********************************************************
 * ********************************************************
 * *****************************************************************
 */
if(isset($_POST['add_member'])){
$member = new Member();
$member->add(
$_POST['firstname'],
$_POST['lastname'],
$_POST['gender'],
$_FILES['profile_image'],
$_POST['phone'],
$_POST['address'],
$_POST['national_id'],
$_POST['password'],
$_POST['email']
);
}//endif
else{

}